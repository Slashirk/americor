<?php

namespace common\services\Customer\helpers;

use common\services\Customer\constants\CustomerConstants;
use Yii;

/**
 * Class CustomerHelper
 * @package common\services\Customer\helpers
 */
class CustomerHelper
{
    /**
     * @return array
     */
    public static function getQualityTexts(): array
    {
        return [
            CustomerConstants::QUALITY_ACTIVE     => Yii::t('app', 'Active'),
            CustomerConstants::QUALITY_REJECTED   => Yii::t('app', 'Rejected'),
            CustomerConstants::QUALITY_COMMUNITY  => Yii::t('app', 'Community'),
            CustomerConstants::QUALITY_UNASSIGNED => Yii::t('app', 'Unassigned'),
            CustomerConstants::QUALITY_TRICKLE    => Yii::t('app', 'Trickle'),
        ];
    }

    /**
     * @param string|null $quality
     *
     * @return string|null
     */
    public static function getQualityTextByQuality(?string $quality): ?string
    {
        return self::getQualityTexts()[$quality] ?? $quality;
    }

    /**
     * @return array
     */
    public static function getTypeTexts(): array
    {
        return [
            CustomerConstants::TYPE_LEAD => Yii::t('app', 'Lead'),
            CustomerConstants::TYPE_DEAL => Yii::t('app', 'Deal'),
            CustomerConstants::TYPE_LOAN => Yii::t('app', 'Loan'),
        ];
    }

    /**
     * @param string|null $type
     *
     * @return string|null
     */
    public static function getTypeTextByType(?string $type): ?string
    {
        return self::getTypeTexts()[$type] ?? $type;
    }
}
