<?php

namespace common\components\Repository\classes\relations;

use common\components\Repository\constants\RelationConstants;
use common\components\Repository\helpers\RepositoryRelationsHelper;
use yii\db\ActiveRecord;
use yii\db\ActiveRecordInterface;

class RelationsGet
{
    /**
     * @param ActiveRecordInterface $parent
     * @param array                 $relation
     * @param array                 $condition
     *
     * @return array|ActiveRecord[]
     */
    public static function get(ActiveRecordInterface $parent, array $relation, array $condition = [])
    {
        $models = [];

        switch (RepositoryRelationsHelper::getRelationType($relation)) {
            case RelationConstants::RELATION_ONE_TO_ONE:
            case RelationConstants::RELATION_ONE_TO_MANY:
                $models = self::oneToAny($parent, $relation, $condition);
                break;
            case RelationConstants::RELATION_MANY_TO_MANY:
                $models = self::manyToMany($parent, $relation, $condition);
                break;
            case RelationConstants::RELATION_LINK_ONE_TO_ONE:
            case RelationConstants::RELATION_LINK_ONE_TO_MANY:
                $models = self::linkOneToAny($parent, $relation, $condition);
                break;
            case RelationConstants::RELATION_LINK_MANY_TO_MANY:
                $models = self::linkManyToMany($parent, $relation, $condition);
                break;
        }

        return $models;
    }

    /**
     * Gets one-to-any
     *
     * @param ActiveRecord $parent
     * @param array        $relation
     * @param array        $condition
     *
     * @return ActiveRecord[]
     */
    protected static function oneToAny(ActiveRecordInterface $parent, array $relation, array $condition = [])
    {
        /** @var ActiveRecord $class */
        $class = $relation['modelClass'];
        $attr = $relation['attributeName'];

        // Return result
        return $class::find()
            ->where([$attr => $parent->primaryKey])
            ->andWhere($condition)
            ->all();
    }

    /**
     * Gets one-to-any by link
     *
     * @param ActiveRecordInterface $parent
     * @param array                 $relation
     * @param array                 $condition
     *
     * @return array|ActiveRecord[]
     */
    protected static function linkOneToAny(ActiveRecordInterface $parent, array $relation, array $condition = [])
    {
        /** @var ActiveRecord $class */
        $class = $relation['modelClass'];
        $classPrimary = $class::primaryKey()[0];

        $link = $relation['linkName'];

        // Return result
        return $class::find()
            ->where([$classPrimary => $parent->getAttribute($link)])
            ->andWhere($condition)
            ->all();
    }

    /**
     * @param ActiveRecordInterface $parent
     * @param array                 $relation
     * @param array                 $condition
     *
     * @return array|ActiveRecord[]
     */
    protected static function manyToMany(ActiveRecordInterface $parent, array $relation, array $condition = [])
    {
        /** @var ActiveRecord $itemClass */
        $itemClass = $relation['modelClass'][1];
        /** @var ActiveRecord $linkClass */
        $linkClass = $relation['modelClass'][0];
        $itemPrimary = $itemClass::primaryKey()[0];

        // Return result
        return $itemClass::find()
            ->where([
                $itemPrimary => $linkClass::find()
                    ->select($relation['attributeName'][1])
                    ->where([$relation['attributeName'][0] => $parent->getPrimaryKey()])
                    ->column()
            ])
            ->andWhere($condition)
            ->all();
    }

    /**
     * Gets one-to-any by link
     *
     * @param ActiveRecordInterface $parent
     * @param array                 $relation
     * @param array                 $condition
     *
     * @return array|ActiveRecord[]
     */
    protected static function linkManyToMany(ActiveRecordInterface $parent, array $relation, array $condition = [])
    {
        /** @var ActiveRecord $itemClass */
        $itemClass = $relation['modelClass'][1];
        /** @var ActiveRecord $linkClass */
        $linkClass = $relation['modelClass'][0];
        $itemPrimary = $itemClass::primaryKey()[0];

        // Return result
        return $itemClass::find()
            ->where([
                $itemPrimary => $linkClass::find()
                    ->select($relation['linkName'][1])
                    ->where([$relation['linkName'][0] => $parent->getPrimaryKey()])
                    ->column()
            ])
            ->andWhere($condition)
            ->all();
    }
}
