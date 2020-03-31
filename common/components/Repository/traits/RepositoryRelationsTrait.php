<?php

namespace common\components\Repository\traits;

use common\components\Repository\classes\relations\RelationsDelete;
use common\components\Repository\classes\relations\RelationsGet;
use common\components\Repository\classes\relations\RelationsSave;
use common\components\Repository\helpers\RepositoryRelationsHelper;
use yii\db\ActiveRecord;
use yii\db\ActiveRecordInterface;
use yii\helpers\ArrayHelper;

trait RepositoryRelationsTrait
{
    public static $relations;

    public function getRelations(
        ActiveRecordInterface $parent,
        array $relations,
        array $repositories = []
    ) {
        $result = ArrayHelper::toArray($parent);

        foreach ($relations as $idx => &$relation) {
            $condition = ArrayHelper::remove($relation, 'condition', []);
            $name = is_array($relation) ? $idx : $relation;

            $models = RelationsGet::get($parent, static::$relations[$name] ?? [], $condition);

            if (!is_array($relation)) {
                $result['relations'][$name] = RepositoryRelationsHelper::prepareModels($models);
            } else {
                $repository = $repositories[$idx] ?? false;

                if (!$repository) {
                    $result['relations'][$name] = RepositoryRelationsHelper::prepareModels($models);
                } else {
                    foreach ($models ?? [] as $model) {
                        $result['relations'][$name][] = $repository->getRelations(
                            $model,
                            $relations[$name],
                            $repositories
                        );
                    }
                }
            }
        }

        return $result;
    }

    /**
     * @param ActiveRecordInterface $parent
     * @param array                 $payload
     * @param bool                  $preventDelete
     * @param array                 $repositories
     *
     * @return array
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     */
    public function saveRelations(
        ActiveRecordInterface $parent,
        array $payload = [],
        $preventDelete = false,
        array $repositories = []
    ) {
        // Start transaction
        $transaction = \Yii::$app->db->beginTransaction();

        // Save Parent if pk is empty
        if (empty($parent->primaryKey)) {
            $parent->save();
        }

        // Save Parent if it has Dirty Attributes
        if (!empty($parent->getDirtyAttributes())) {
            $parent->save();
        }

        // Process Relations
        $result = $this->processRelations($parent, $payload, $preventDelete, $repositories);

        // Check is payload has errors and process transaction + caches
        $hasErrors = RepositoryRelationsHelper::payloadHasErrors($result);

        if ($hasErrors) {
            $transaction->rollBack();
        } else {
            $transaction->commit();
        }

        // Return result
        return $result;
    }

    /**
     * @param ActiveRecord $parent
     * @param array        $payload
     * @param bool         $preventDelete
     * @param array        $repositories
     *
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    protected function processRelations(
        ActiveRecordInterface $parent,
        array $payload = [],
        $preventDelete = false,
        array $repositories = []
    ) {
        // Base Result
        $result = RepositoryRelationsHelper::prepareModel($parent);

        // Process Relations
        foreach ($payload['relations'] ?? [] as $name => $items) {
            // Get Relation by Name
            $relation = static::$relations[$name] ?? [];

            // Delete relations if needed
            if (!$preventDelete) {
                RelationsDelete::delete($parent, $relation, $items);
            }

            // Process sub-relations recursive
            $models = RelationsSave::save($parent, $relation, $items);

            // Get Repository
            $repository = $repositories[$name] ?? false;

            if (!$repository) {
                $result['relations'][$name] = RepositoryRelationsHelper::prepareModels($models);
            } else {
                foreach ($models ?? [] as $idx => $model) {
                    $result['relations'][$name][] = $repository->processRelations(
                        $model,
                        $items[$idx],
                        $preventDelete,
                        $repositories
                    );
                }
            }
        }

        return $result;
    }
}
