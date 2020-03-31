<?php

namespace common\services\Fax\helpers;

use common\services\Fax\constants\FaxConstants;
use common\services\Fax\models\Fax;
use Yii;

/**
 * Class FaxHelper
 * @package common\services\Fax\helpers
 */
class FaxHelper
{
    /**
     * @return array
     */
    public static function getTypeTexts(): array
    {
        return [
            FaxConstants::TYPE_POA_ATC           => Yii::t('app', 'POA/ATC'),
            FaxConstants::TYPE_REVOCATION_NOTICE => Yii::t('app', 'Revocation'),
        ];
    }

    /**
     * @param array $model
     *
     * @return string
     */
    public static function getTypeText(array $model): string
    {
        return self::getTypeTexts()[$model['type']] ?? $model['type'];
    }
}
