<?php

namespace common\widgets\HistoryList\factories\HistoryBody\classes;

use common\services\History\constants\HistoryObjectsConstants;
use common\widgets\HistoryList\interfaces\HistoryListBodyInterface;
use yii\helpers\ArrayHelper;

class SmsBody implements HistoryListBodyInterface
{
    /** @var array */
    private $model;

    /**
     * SmsBody constructor.
     *
     * @param array $model
     */
    public function __construct(array $model)
    {
        $this->model = $model;
    }

    /**
     * @return string
     */
    public function render(): string
    {
        $sms = ArrayHelper::getValue($this->model, ['links', HistoryObjectsConstants::OBJECT_SMS], []);
        return ArrayHelper::getValue($sms, ['message'], '');
    }
}
