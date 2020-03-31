<?php

namespace common\widgets\HistoryList\factories\HistoryBody\classes;

use common\services\History\helpers\HistoryEventsHelper;
use common\widgets\HistoryList\interfaces\HistoryListBodyInterface;

class FaxBody implements HistoryListBodyInterface
{
    /** @var array */
    private $model;

    /**
     * FaxBody constructor.
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
        return HistoryEventsHelper::getEventText($this->model);
    }
}
