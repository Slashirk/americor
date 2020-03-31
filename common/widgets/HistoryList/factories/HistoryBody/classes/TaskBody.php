<?php

namespace common\widgets\HistoryList\factories\HistoryBody\classes;

use common\services\History\constants\HistoryObjectsConstants;
use common\services\History\helpers\HistoryEventsHelper;
use common\widgets\HistoryList\interfaces\HistoryListBodyInterface;
use yii\helpers\ArrayHelper;

class TaskBody implements HistoryListBodyInterface
{
    /** @var array */
    private $model;

    /**
     * TaskBody constructor.
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
        $task = ArrayHelper::getValue($this->model, ['links', HistoryObjectsConstants::OBJECT_TASK], []);
        $title = ArrayHelper::getValue($task, 'title', '');

        return HistoryEventsHelper::getEventText($this->model) . ": " . $title;
    }
}
