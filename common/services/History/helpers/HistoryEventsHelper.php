<?php

namespace common\services\History\helpers;

use common\services\History\constants\HistoryEventConstants;
use Yii;

/**
 * Class HistoryEventsHelper
 * @package common\services\History\helpers
 */
class HistoryEventsHelper
{
    /**
     * @return array
     */
    public static function getEventTexts(): array
    {
        return [
            HistoryEventConstants::EVENT_CREATED_TASK   => Yii::t('app', 'Task created'),
            HistoryEventConstants::EVENT_UPDATED_TASK   => Yii::t('app', 'Task updated'),
            HistoryEventConstants::EVENT_COMPLETED_TASK => Yii::t('app', 'Task completed'),

            HistoryEventConstants::EVENT_INCOMING_SMS => Yii::t('app', 'Incoming message'),
            HistoryEventConstants::EVENT_OUTGOING_SMS => Yii::t('app', 'Outgoing message'),

            HistoryEventConstants::EVENT_CUSTOMER_CHANGE_TYPE    => Yii::t('app', 'Type changed'),
            HistoryEventConstants::EVENT_CUSTOMER_CHANGE_QUALITY => Yii::t('app', 'Property changed'),

            HistoryEventConstants::EVENT_OUTGOING_CALL => Yii::t('app', 'Outgoing call'),
            HistoryEventConstants::EVENT_INCOMING_CALL => Yii::t('app', 'Incoming call'),

            HistoryEventConstants::EVENT_INCOMING_FAX => Yii::t('app', 'Incoming fax'),
            HistoryEventConstants::EVENT_OUTGOING_FAX => Yii::t('app', 'Outgoing fax'),
        ];
    }

    /**
     * @param $event
     *
     * @return string
     */
    public static function getEventTextByEvent(string $event): string
    {
        return static::getEventTexts()[$event] ?? $event;
    }

    /**
     * @param array $model
     *
     * @return string
     */
    public static function getEventText(array $model): string
    {
        return static::getEventTextByEvent($model['event']);
    }
}
