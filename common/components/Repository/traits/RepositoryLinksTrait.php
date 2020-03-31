<?php

namespace common\components\Repository\traits;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

trait RepositoryLinksTrait
{
    /** @var string */
    public static $linkField;

    /** @var string */
    public static $linkFieldId;

    /** @var array */
    public static $links;

    /**
     * @param array $parents
     *
     * @return array
     */
    public function getLinked(array $parents = [])
    {
        $linksIds = $this->getLinksIds($parents);
        $linkedModels = $this->getLinkedData($linksIds);

        foreach ($parents as &$parent) {
            $linkName = ArrayHelper::getValue($parent, static::$linkField);
            $linkId = ArrayHelper::getValue($parent, static::$linkFieldId);
            $linkModel = ArrayHelper::getValue($linkedModels, [$linkName, $linkId]);

            if (!empty($linkModel)) {
                $parent['links'][$linkName] = $linkModel;
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
    private function getLinksIds(array $parents = []): array
    {
        $result = [];
        foreach ($parents as $parent) {
            $linkName = ArrayHelper::getValue($parent, static::$linkField);
            $linkId = ArrayHelper::getValue($parent, static::$linkFieldId);

            if (!empty($linkName) && !empty($linkId)) {
                $result[$linkName][] = $linkId;
            }
        }

        return $result;
    }

    /**
     * @param array $linksIds
     *
     * @return array
     */
    private function getLinkedData(array $linksIds = []): array
    {
        $result = [];

        foreach ($linksIds as $name => $ids) {
            /** @var ActiveRecord $class */
            $class = ArrayHelper::getValue(static::$links, [$name, 'modelClass']);
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
