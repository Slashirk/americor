<?php

namespace common\widgets\HistoryList\factories\HistoryObjects\classes;

use common\services\Customer\helpers\CustomerHelper;
use common\services\History\constants\HistoryEventConstants;
use common\services\History\helpers\HistoryDetailHelper;
use common\widgets\HistoryList\interfaces\HistoryListObjectInterface;
use yii\helpers\ArrayHelper;

class CustomerObject implements HistoryListObjectInterface
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
     * @return array
     */
    public function get(): array
    {
        $view = '_item_statuses_change';
        $params = [];

        $event = ArrayHelper::getValue($this->model, 'event');

        switch ($event) {
            case HistoryEventConstants::EVENT_CUSTOMER_CHANGE_TYPE:
                $params = [
                    'model'    => $this->model,
                    'oldValue' => CustomerHelper::getTypeTextByType(
                        HistoryDetailHelper::getDetailOldValue($this->model, 'type')
                    ),
                    'newValue' => CustomerHelper::getTypeTextByType(
                        HistoryDetailHelper::getDetailNewValue($this->model, 'type')
                    )
                ];
                break;
            case HistoryEventConstants::EVENT_CUSTOMER_CHANGE_QUALITY:
                $params = [
                    'model'    => $this->model,
                    'oldValue' => CustomerHelper::getQualityTextByQuality(
                        HistoryDetailHelper::getDetailOldValue($this->model, 'quality')
                    ),
                    'newValue' => CustomerHelper::getQualityTextByQuality(
                        HistoryDetailHelper::getDetailNewValue($this->model, 'quality')
                    ),
                ];
                break;
        }

        return [$view, $params];
    }
}
