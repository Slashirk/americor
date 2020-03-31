<?php

namespace common\services\History\helpers;

use yii\helpers\ArrayHelper;

/**
 * Class HistoryDetailHelper
 * @package common\services\History\helpers
 */
class HistoryDetailHelper
{
    /**
     * @param array  $model
     * @param string $attribute
     *
     * @return string|null
     */
    public static function getDetailOldValue(array $model, string $attribute): ?string
    {
        $detail = static::getDetailChangedAttribute($model, $attribute);
        return ArrayHelper::getValue($detail, 'old');
    }

    /**
     * @param array  $model
     * @param string $attribute
     *
     * @return string|null
     */
    public static function getDetailNewValue(array $model, string $attribute): ?string
    {
        $detail = static::getDetailChangedAttribute($model, $attribute);
        return ArrayHelper::getValue($detail, 'old');
    }

    /**
     * @param array  $model
     * @param string $attribute
     *
     * @return array|null
     */
    protected static function getDetailChangedAttribute(array $model, string $attribute): ?array
    {
        $detail = json_decode(ArrayHelper::getValue($model, 'detail'), true);
        return ArrayHelper::getValue($detail, "changedAttributes.{$attribute}");
    }
}
