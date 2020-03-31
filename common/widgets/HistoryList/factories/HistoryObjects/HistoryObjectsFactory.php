<?php

namespace common\widgets\HistoryList\factories\HistoryObjects;

use common\widgets\HistoryList\factories\HistoryObjects\classes\DefaultObject;
use common\widgets\HistoryList\factories\HistoryObjects\constants\HistoryObjectsFactoryConstants;
use common\widgets\HistoryList\interfaces\HistoryListObjectInterface;
use yii\helpers\ArrayHelper;

class HistoryObjectsFactory
{
    /**
     * @param array $model
     *
     * @return HistoryListObjectInterface
     */
    public static function getObject(array $model): HistoryListObjectInterface
    {
        $object = ArrayHelper::getValue($model, 'object');
        $bodyClass = ArrayHelper::getValue(HistoryObjectsFactoryConstants::LIST, $object);

        if (!empty($bodyClass)) {
            return new $bodyClass($model);
        } else {
            return new DefaultObject($model);
        }
    }
}
