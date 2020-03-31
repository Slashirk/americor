<?php

namespace common\components\Repository\classes\relations;

use common\components\Repository\constants\RelationConstants;
use common\components\Repository\helpers\RepositoryRelationsHelper;
use yii\db\ActiveRecord;
use yii\db\ActiveRecordInterface;
use yii\helpers\ArrayHelper;

class RelationsDelete
{
    /**
     * Removes Relations by Type
     *
     * @param ActiveRecord $parent
     * @param array        $relation
     * @param array        $items
     *
     * @throws \yii\base\InvalidConfigException
     */
    public static function delete(ActiveRecordInterface $parent, array $relation, array $items = [])
    {
        switch (RepositoryRelationsHelper::getRelationType($relation)) {
            case RelationConstants::RELATION_ONE_TO_ONE:
                self::oneToOne(
                    $parent,
                    $relation
                );
                break;
            case RelationConstants::RELATION_ONE_TO_MANY:
                self::oneToMany(
                    $parent,
                    $relation,
                    self::filterPrimaryKeys(
                        $relation['modelClass'],
                        ArrayHelper::getColumn($items, $relation['modelClass']::primaryKey()[0])
                    )
                );
                break;
            case RelationConstants::RELATION_MANY_TO_MANY:
                self::manyToMany(
                    $parent,
                    $relation,
                    self::filterPrimaryKeys(
                        $relation['modelClass'][1],
                        ArrayHelper::getColumn($items, $relation['modelClass'][1]::primaryKey()[0])
                    )
                );
                break;
        }
    }

    /**
     * Removes one-to-one relations
     *
     * @param ActiveRecord $parent
     * @param array        $relation
     */
    protected static function oneToOne(ActiveRecordInterface $parent, array $relation)
    {
        $relation['modelClass']::deleteAll([
            $relation['attributeName'] => $parent->getPrimaryKey()
        ]);
    }

    /**
     * Removes one-to-many relations
     *
     * @param ActiveRecord $parent
     * @param array        $relation
     * @param array        $ids
     */
    protected static function oneToMany(ActiveRecordInterface $parent, array $relation, array $ids)
    {
        $relation['modelClass']::deleteAll([
            'and',
            [$relation['attributeName'] => $parent->getPrimaryKey()],
            ['not', [$relation['modelClass']::primaryKey()[0] => array_filter($ids)]]
        ]);
    }

    /**
     * Removes many-to-many relations
     *
     * @param ActiveRecord $parent
     * @param array        $relation
     * @param array        $ids
     */
    protected static function manyToMany(ActiveRecordInterface $parent, array $relation, array $ids)
    {
        $ids = $relation['modelClass'][0]::find()
            ->select([$relation['attributeName'][1]])
            ->where([
                'and',
                [$relation['attributeName'][0] => $parent->getPrimaryKey()],
                ['not', [$relation['attributeName'][1] => array_filter($ids)]]
            ])
            ->column();

        $relation['modelClass'][0]::deleteAll([
            $relation['attributeName'][0] => $parent->getPrimaryKey(),
            $relation['attributeName'][1] => $ids
        ]);

        $relation['modelClass'][1]::deleteAll([
            $relation['modelClass'][1]::primaryKey()[0] => $ids
        ]);
    }

    /**
     * @param ActiveRecord $model
     * @param array        $ids
     *
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    private static function filterPrimaryKeys($model, array $ids = []): array
    {
        $schema = $model::getTableSchema();
        $primaryKey = $model::primaryKey()[0];
        $primaryKeyType = ArrayHelper::getValue($schema, ['columns', $primaryKey, 'phpType']);

        $map = [
            'string'  => 'is_string',
            'boolean' => 'is_bool',
            'integer' => 'is_int',
            'double'  => 'is_double',
            'array'   => 'is_array'
        ];

        return array_filter($ids, $map[$primaryKeyType] ?? 'is_numeric');
    }
}
