<?php

namespace common\components\Repository\traits;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

trait RepositorySingleLevelRelationsTrait
{
    /**
     * @param array $parents
     *
     * @return array
     */
    public function getRelated(array $parents = [])
    {
        $relatedIds = $this->getRelatedIds($parents);
        $relatedModels = $this->getRelatedData($relatedIds);

        foreach ($parents as &$parent) {
            foreach (static::$relations ?? [] as $name => $relation) {
                $attributeName = $relation['attributeName'];
                $relatedId = ArrayHelper::getValue($parent, $attributeName);

                if (!empty($relatedId)) {
                    $parent['relations'][$name] = ArrayHelper::getValue($relatedModels, [$name, $relatedId]);
                }
            }
        }
        unset($parent);

        return $parents;
    }

    /**
     * @param array $parents
     *
     * @return array
     */
    private function getRelatedIds(array $parents = []): array
    {
        $result = [];
        foreach ($parents as $parent) {
            foreach (static::$relations ?? [] as $name => $relation) {
                $attributeName = $relation['attributeName'];
                $relatedId = ArrayHelper::getValue($parent, $attributeName);
                if (!empty($relatedId)) {
                    $result[$name][] = $relatedId;
                }
            }
        }

        foreach ($result as &$item) {
            $item = array_unique($item);
        }
        unset($item);

        return $result;
    }

    /**
     * @param array $relatedIds
     *
     * @return array
     */
    private function getRelatedData(array $relatedIds = []): array
    {
        $result = [];

        foreach ($relatedIds as $name => $ids) {
            /** @var ActiveRecord $class */
            $class = ArrayHelper::getValue(static::$relations, [$name, 'modelClass']);

            if (empty($class)) {
                continue;
            }

            $result[$name] = ArrayHelper::index(
                $class::find()
                    ->where([$class::primaryKey()[0] => $ids])
                    ->asArray()
                    ->all(),
                $class::primaryKey()[0]
            );
        }

        return $result;
    }
}
