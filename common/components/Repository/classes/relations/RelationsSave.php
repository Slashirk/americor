<?php

namespace common\components\Repository\classes\relations;

use common\components\Repository\constants\RelationConstants;
use common\components\Repository\helpers\RepositoryRelationsHelper;
use yii\db\ActiveRecord;
use yii\db\ActiveRecordInterface;
use yii\helpers\ArrayHelper;

class RelationsSave
{
    /**
     * Saves Relations by Type
     *
     * @param ActiveRecordInterface $parent
     * @param array                 $relation
     * @param array                 $items
     *
     * @return array
     */
    public static function save(ActiveRecordInterface $parent, array $relation, array $items = []): array
    {
        $models = [];

        foreach ($items as $item) {
            switch (RepositoryRelationsHelper::getRelationType($relation)) {
                case RelationConstants::RELATION_ONE_TO_ONE:
                    $models[] = self::oneToOne($parent, $relation, $item);
                    break;
                case RelationConstants::RELATION_ONE_TO_MANY:
                    $models[] = self::oneToMany($parent, $relation, $item);
                    break;
                case RelationConstants::RELATION_MANY_TO_MANY:
                    $models[] = self::manyToMany($parent, $relation, $item);
                    break;
            }
        }

        return $models;
    }

    /**
     * Saves one-to-any
     *
     * @param ActiveRecordInterface $parent
     * @param array                 $relation
     * @param array                 $item
     *
     * @return ActiveRecord
     */
    protected static function oneToOne(ActiveRecordInterface $parent, array $relation, array $item): ActiveRecord
    {
        $class = $relation['modelClass'];
        $attr = $relation['attributeName'];

        /** @var ActiveRecord $model */
        $model = isset($item[$attr]) ?
            $class::findOne([$attr => $parent->getPrimaryKey()]) ?? new $class()
            : new $class();

        $model->setAttributes(ArrayHelper::merge($item, [$attr => $parent->getPrimaryKey()]));
        $model->save();

        return $model;
    }

    /**
     * Saves one-to-any
     *
     * @param ActiveRecordInterface $parent
     * @param array                 $relation
     * @param array                 $item
     *
     * @return ActiveRecord
     */
    protected static function oneToMany(ActiveRecordInterface $parent, array $relation, array $item): ActiveRecord
    {
        $class = $relation['modelClass'];
        $attr = $relation['attributeName'];
        $primary = $class::primaryKey()[0];

        /** @var ActiveRecord $model */
        $model = isset($item[$primary]) ? $class::findOne([$primary => $item[$primary]]) ?? new $class() : new $class();

        // Check if parent id matches
        if (!empty($model->getAttribute($attr)) && $model->getAttribute($attr) != $parent->getPrimaryKey()) {
            $model = new $class();
            $model->setAttributes(ArrayHelper::merge($item, [$attr => $parent->getPrimaryKey()]));
            $model->setAttribute($model::primaryKey()[0], null);
            $model->isNewRecord = true;
            $model->save();
        } else {
            $model->setAttributes(ArrayHelper::merge($item, [$attr => $parent->getPrimaryKey()]));
            $model->save();
        }

        return $model;
    }

    /**
     * Saves many-to-many
     *
     * @param ActiveRecordInterface $parent
     * @param array                 $relation
     * @param array                 $item
     *
     * @return ActiveRecord
     */
    protected static function manyToMany(ActiveRecordInterface $parent, array $relation, array $item): ActiveRecord
    {
        /** @var ActiveRecord $itemClass */
        $itemClass = $relation['modelClass'][1];
        /** @var ActiveRecord $linkClass */
        $linkClass = $relation['modelClass'][0];
        $itemPrimary = $itemClass::primaryKey()[0];

        /** @var ActiveRecord $model */
        $model = isset($item[$itemPrimary]) ?
            $itemClass::findOne($item[$itemPrimary]) ?? new $itemClass() : new $itemClass();


        $mode = $model->getPrimaryKey() ? 'update' : 'insert';

        // Check If parent matches
        if ($mode == 'update') {
            $manyToManyModel = $linkClass::findOne([
                $relation['attributeName'][0] => $parent->getPrimaryKey(),
                $relation['attributeName'][1] => $model->getPrimaryKey()
            ]);

            if (empty($manyToManyModel)) {
                $mode = 'insert';
                $model = new $itemClass();
                $model->setAttributes($item);
                $model->setAttribute($itemPrimary, null);
                $model->isNewRecord = true;
                $model->save();
            } else {
                $model->setAttributes($item);
                $model->save();
            }
        } else {
            $model->setAttributes($item);
            $model->save();
        }

        /** @var ActiveRecord $manyToManyModel */
        if ($model->getPrimaryKey() && $mode == 'insert') {
            $manyToManyModel = new $linkClass([
                $relation['attributeName'][0] => $parent->getPrimaryKey(),
                $relation['attributeName'][1] => $model->getPrimaryKey()
            ]);
            $manyToManyModel->save();
        }

        return $model;
    }
}
