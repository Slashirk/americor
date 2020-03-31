<?php

namespace common\components\Repository\helpers;

use common\components\Repository\constants\RelationConstants;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class RepositoryRelationsHelper
{

    public static function prepareModels(array $models = [])
    {
        $result = [];

        foreach ($models as $model) {
            $result[] = static::prepareModel($model);
        }

        return $result;
    }

    public static function prepareModel(ActiveRecord $model)
    {
        $prepared = ArrayHelper::toArray($model);
        if ($model->hasErrors()) {
            $prepared['errors'] = $model->getErrors();
        }
        return $prepared;
    }

    /**
     * Filters not existed relations from POST
     *
     * @param array $post
     * @param array $existedRelations
     *
     * @return array
     */
    public static function filterRelations($post = [], $existedRelations = []): array
    {
        // If nothing to compare - returns post
        if (!isset($post['relations']) || empty($existedRelations)) {
            return $post;
        }

        // Difference between post relations and existed relations
        $relationsThatAreDoesNotExist = array_diff_key($post['relations'], $existedRelations);

        // If there anything to remove from relations list
        if (!empty($relationsThatAreDoesNotExist)) {
            foreach ($relationsThatAreDoesNotExist as $relationName => $relationValue) {
                unset($post['relations'][$relationName]);
            }
        }

        // If filtered relations are empty - removes them all
        if (empty($post['relations'])) {
            unset($post['relations']);
        }

        // Returns filtered post data
        return $post;
    }

    /**
     * Checks if payload has any errors
     *
     * @param array $payload
     *
     * @return bool
     */
    public static function payloadHasErrors(array $payload = []): bool
    {
        $hasErrors = false;
        array_walk_recursive($payload, function ($v, $k) use (&$hasErrors) {
            if ($k == 'errors' && !empty($v)) {
                $hasErrors = true;
            }
        });
        return $hasErrors;
    }

    public static function getRelationType(array $relation): ?int
    {

        if (empty($relation['modelClass']) || (empty($relation['attributeName']) && empty($relation['linkName']))) {
            return null;
        }

        /** @var ActiveRecord $model */
        $model = $relation['modelClass'];

        if (!empty($relation['attributeName'])) {
            if (is_array($relation['modelClass']) && is_array($relation['attributeName'])) {
                return RelationConstants::RELATION_MANY_TO_MANY;
            }

            if ($model::primaryKey() === $relation['attributeName']) {
                return RelationConstants::RELATION_ONE_TO_ONE;
            }

            return RelationConstants::RELATION_ONE_TO_MANY;
        } else {
            if (is_array($relation['modelClass']) && is_array($relation['linkName'])) {
                return RelationConstants::RELATION_LINK_MANY_TO_MANY;
            }

            if ($model::primaryKey() === $relation['linkName']) {
                return RelationConstants::RELATION_LINK_ONE_TO_ONE;
            }

            return RelationConstants::RELATION_LINK_ONE_TO_MANY;
        }

    }

    /**
     * Sets Predefined Values by Paths
     *
     * @param array $payload
     * @param array $predefinedItems
     *
     * @return array
     */
    public static function setPredefined(array $payload = [], array $predefinedItems = []): array
    {
        $paths = static::buildPaths($payload);

        foreach ($paths as $path) {
            foreach ($predefinedItems as $predefinedItem) {
                if (static::checkIfPathMatches($path, $predefinedItem)) {
                    ArrayHelper::setValue(
                        $payload,
                        str_replace('root.', '', $path),
                        $predefinedItem[1]
                    );
                } elseif (static::checkIfParentMatches($path, $predefinedItem)) {
                    ArrayHelper::setValue(
                        $payload,
                        str_replace(
                            'root.',
                            '',
                            implode('.', array_slice(explode('.', $path), 0, -1)) . '.' . $predefinedItem[0]
                        ),
                        $predefinedItem[1]
                    );
                } elseif (($predefinedItem[2] ?? '') === 'root') {
                    ArrayHelper::setValue($payload, $predefinedItem[0], $predefinedItem[1]);
                }
            }
        }

        return $payload;
    }

    /**
     * Checks if path matches
     *
     * @param string $path
     * @param array  $predefined
     *
     * @return bool
     */
    protected static function checkIfPathMatches(string $path, array $predefined = []): bool
    {
        $path = preg_replace(["/.[0-9]+/", "/.relations/"], "", $path);
        if (isset($predefined[2])) {
            return $path === $predefined[2] . '.' . $predefined[0];
        } else {
            return end(explode('.', $path)) === $predefined[0];
        }
    }

    /**
     * Checks if parent path matches
     *
     * @param string $path
     * @param array  $predefined
     *
     * @return bool
     */
    protected static function checkIfParentMatches(string $path, array $predefined = []): bool
    {
        $path = preg_replace(["/.[0-9]+/", "/.relations/"], "", $path);

        if (isset($predefined[2])) {
            return implode('.', array_slice(explode('.', $path), 0, -1)) === $predefined[2];
        } else {
            return false;
        }
    }

    /**
     * Builds All paths of an array
     *
     * @param array  $payload
     * @param string $currentPath
     *
     * @return array
     */
    protected static function buildPaths(array $payload = [], $currentPath = 'root'): array
    {
        $path = [];
        foreach ($payload as $k => $v) {
            if (is_array($v)) {
                $path = ArrayHelper::merge(
                    $path,
                    static::buildPaths($v, $currentPath . '.' . $k)
                );
            } else {
                $path[] = $currentPath . '.' . $k;
            }
        }
        return $path;
    }
}
