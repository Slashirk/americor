<?php

namespace common\services\Sms\helpers;

use common\services\Sms\constants\SmsConstants;
use common\services\Sms\models\Sms;
use Yii;

/**
 * Class SmsHelper
 * @package common\services\Sms\helpers
 */
class SmsHelper
{
    /**
     * @return array
     */
    public static function getStatusTexts(): array
    {
        return [
            SmsConstants::STATUS_NEW      => Yii::t('app', 'New'),
            SmsConstants::STATUS_READ     => Yii::t('app', 'Read'),
            SmsConstants::STATUS_ANSWERED => Yii::t('app', 'Answered'),

            SmsConstants::STATUS_DRAFT     => Yii::t('app', 'Draft'),
            SmsConstants::STATUS_WAIT      => Yii::t('app', 'Wait'),
            SmsConstants::STATUS_SENT      => Yii::t('app', 'Sent'),
            SmsConstants::STATUS_DELIVERED => Yii::t('app', 'Delivered'),
        ];
    }

    /**
     * @param int $value
     *
     * @return string
     */
    public static function getStatusTextByValue(int $value): string
    {
        return self::getStatusTexts()[$value] ?? (string)$value;
    }

    /**
     * @param array $model
     *
     * @return string
     */
    public function getStatusText(array $model): string
    {
        return self::getStatusTextByValue($model['status']);
    }

    /**
     * @return array
     */
    public static function getDirectionTexts(): array
    {
        return [
            SmsConstants::DIRECTION_INCOMING => Yii::t('app', 'Incoming'),
            SmsConstants::DIRECTION_OUTGOING => Yii::t('app', 'Outgoing'),
        ];
    }

    /**
     * @param int $value
     *
     * @return string
     */
    public static function getDirectionTextByValue(int $value): string
    {
        return self::getDirectionTexts()[$value] ?? (string)$value;
    }

    /**
     * @param array $model
     *
     * @return string
     */
    public function getDirectionText(array $model): string
    {
        return self::getDirectionTextByValue($model['direction']);
    }
}
