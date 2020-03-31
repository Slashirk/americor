<?php

namespace common\services\Call\helpers;

use common\services\Call\constants\CallConstants;
use common\services\Call\models\Call;
use Yii;

/**
 * Class CallHelper
 * @package common\services\Call\helpers
 */
class CallHelper
{
    /**
     * @param array $model
     *
     * @return string
     */
    public static function getClientPhone(array $model): string
    {
        return $model['direction'] == CallConstants::DIRECTION_INCOMING ? $model['phone_from'] : $model['phone_to'];
    }

    /**
     * @param array $model
     *
     * @return string
     */
    public static function getTotalStatusText(array $model): string
    {
        if (
            $model['status'] == CallConstants::STATUS_NO_ANSWERED
            && $model['direction'] == CallConstants::DIRECTION_INCOMING
        ) {
            return Yii::t('app', 'Missed Call');
        }

        if (
            $model['status'] == CallConstants::STATUS_NO_ANSWERED
            && $model['direction'] == CallConstants::DIRECTION_OUTGOING
        ) {
            return Yii::t('app', 'Client No Answer');
        }

        $msg = static::getFullDirectionText($model);

        if ($model['duration']) {
            $msg .= ' (' . static::getDurationText($model) . ')';
        }

        return $msg;
    }

    /**
     * @param array $model
     * @param bool $hasComment
     *
     * @return string
     */
    public static function getTotalDisposition(array $model, $hasComment = true): string
    {
        $t = [];
        if ($hasComment && $model['comment']) {
            $t[] = $model['comment'];
        }
        return implode(': ', $t);
    }

    /**
     * @return array
     */
    public static function getFullDirectionTexts(): array
    {
        return [
            CallConstants::DIRECTION_INCOMING => Yii::t('app', 'Incoming Call'),
            CallConstants::DIRECTION_OUTGOING => Yii::t('app', 'Outgoing Call'),
        ];
    }

    /**
     * @param array $model
     *
     * @return string
     */
    public static function getFullDirectionText(array $model): string
    {
        $a = self::getFullDirectionTexts();
        return $a[$model['direction']] ?? $model['direction'];
    }

    /**
     * @param array $model
     *
     * @return false|string
     */
    public static function getDurationText(array $model)
    {
        if (!is_null($model['duration'])) {
            return $model['duration'] >= 3600 ? gmdate("H:i:s", $model['duration']) : gmdate("i:s", $model['duration']);
        }
        return '00:00';
    }
}
