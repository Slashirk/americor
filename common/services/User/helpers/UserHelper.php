<?php

namespace common\services\User\helpers;

use app\models\User;
use common\services\User\constants\UserConstants;
use Yii;

/**
 * Class UserHelper
 * @package common\services\User\helpers
 */
class UserHelper
{
    /**
     * @return array
     */
    public static function getStatusTexts(): array
    {
        return [
            UserConstants::STATUS_ACTIVE  => Yii::t('app', 'Active'),
            UserConstants::STATUS_DELETED => Yii::t('app', 'Deleted'),
            UserConstants::STATUS_HIDDEN  => Yii::t('app', 'Hidden'),
        ];
    }

    /**
     * @param array $model
     *
     * @return string
     */
    public function getStatusText(array $model): string
    {
        return self::getStatusTexts()[$model['status']] ?? (string)$model['status'];
    }
}
