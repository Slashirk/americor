<?php

namespace common\widgets\HistoryList\factories\HistoryBody\classes;

use common\services\Call\helpers\CallHelper;
use common\services\History\constants\HistoryObjectsConstants;
use common\widgets\HistoryList\interfaces\HistoryListBodyInterface;
use yii\helpers\ArrayHelper;

class CallBody implements HistoryListBodyInterface
{
    /** @var array */
    private $model;

    /**
     * CallBody constructor.
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
        $call = ArrayHelper::getValue($this->model, ['links', HistoryObjectsConstants::OBJECT_CALL], []);

        return ($call ? CallHelper::getTotalStatusText($call) . (CallHelper::getTotalDisposition($call,
                false) ? " <span class='text-grey'>" . CallHelper::getTotalDisposition($call,
                    false) . "</span>" : "") : '<i>Deleted</i> ');
    }
}
