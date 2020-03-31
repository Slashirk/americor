<?php

namespace common\widgets\HistoryList\factories\HistoryBody\classes;

use common\services\Customer\helpers\CustomerHelper;
use common\services\History\constants\HistoryEventConstants;
use common\services\History\helpers\HistoryDetailHelper;
use common\services\History\helpers\HistoryEventsHelper;
use common\widgets\HistoryList\interfaces\HistoryListBodyInterface;
use yii\helpers\ArrayHelper;

class CustomerBody implements HistoryListBodyInterface
{
    /** @var array */
    private $model;

    /**
     * CustomerBody constructor.
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
        $event = ArrayHelper::getValue($this->model, 'event');

        switch ($event) {
            case HistoryEventConstants::EVENT_CUSTOMER_CHANGE_TYPE:
                return HistoryEventsHelper::getEventText($this->model) . " " .
                    (CustomerHelper::getTypeTextByType(HistoryDetailHelper::getDetailOldValue($this->model,
                            'type')) ?? "not set") . ' to ' .
                    (CustomerHelper::getTypeTextByType(HistoryDetailHelper::getDetailNewValue($this->model,
                            'type')) ?? "not set");
            case HistoryEventConstants::EVENT_CUSTOMER_CHANGE_QUALITY:
                return HistoryEventsHelper::getEventText($this->model) . " " .
                    (CustomerHelper::getQualityTextByQuality(HistoryDetailHelper::getDetailOldValue($this->model,
                            'quality')) ?? "not set") . ' to ' .
                    (CustomerHelper::getQualityTextByQuality(HistoryDetailHelper::getDetailNewValue($this->model,
                            'quality')) ?? "not set");
        }
    }
}
