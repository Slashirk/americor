<?php

namespace common\widgets\HistoryList\factories\HistoryBody;

use common\widgets\HistoryList\factories\HistoryBody\classes\DefaultBody;
use common\widgets\HistoryList\factories\HistoryBody\constants\HistoryBodyFactoryConstants;
use common\widgets\HistoryList\interfaces\HistoryListBodyInterface;
use yii\helpers\ArrayHelper;

class HistoryBodyFactory
{
    /**
     * @param array $model
     *
     * @return HistoryListBodyInterface
     */
    public static function getBody(array $model): HistoryListBodyInterface
    {
        $object = ArrayHelper::getValue($model, 'object');
        $bodyClass = ArrayHelper::getValue(HistoryBodyFactoryConstants::LIST, $object);

        if (!empty($bodyClass)) {
            return new $bodyClass($model);
        } else {
            return new DefaultBody($model);
        }
    }
}
