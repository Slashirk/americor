<?php

namespace common\services\Task\helpers;

use common\services\Task\constants\TaskConstants;
use common\services\Task\models\Task;
use Yii;

/**
 * Class TaskHelper
 * @package common\services\Task\helpers
 */
class TaskHelper
{
    /**
     * @return array
     */
    public static function getStatusTexts(): array
    {
        return [
            TaskConstants::STATUS_NEW    => Yii::t('app', 'New'),
            TaskConstants::STATUS_DONE   => Yii::t('app', 'Complete'),
            TaskConstants::STATUS_CANCEL => Yii::t('app', 'Cancel'),
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
    public static function getStatusText(array $model): string
    {
        return self::getStatusTextByValue($model['status']);
    }


    /**
     * @return array
     */
    public static function getStateTexts(): array
    {
        return [
            TaskConstants::STATE_INBOX  => Yii::t('app', 'Inbox'),
            TaskConstants::STATE_DONE   => Yii::t('app', 'Done'),
            TaskConstants::STATE_FUTURE => Yii::t('app', 'Future')
        ];
    }

    /**
     * @param array $model
     *
     * @return string
     */
    public static function getStateText(array $model): string
    {
        return self::getStateTexts()[$model['state']] ?? $model['state'];
    }

    /**
     * @param array $model
     *
     * @return bool
     */
    public static function getIsOverdue(array $model): bool
    {
        return $model['status'] !== TaskConstants::STATUS_DONE && strtotime($model['due_date']) < time();
    }

    /**
     * @param array $model
     *
     * @return bool
     */
    public static function getIsDone(array $model): bool
    {
        return $model['status'] == TaskConstants::STATUS_DONE;
    }
}
