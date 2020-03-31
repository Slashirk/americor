<?php

namespace common\widgets\HistoryList\factories\HistoryObjects\classes;

use common\widgets\HistoryList\factories\HistoryBody\HistoryBodyFactory;
use common\widgets\HistoryList\interfaces\HistoryListObjectInterface;
use yii\helpers\ArrayHelper;

class TaskObject implements HistoryListObjectInterface
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
     * @return array
     */
    public function get(): array
    {
        $view = '_item_common';
        $params = [
            'user'           => ArrayHelper::getValue($this->model, ['relations', 'user']),
            'body'           => (HistoryBodyFactory::getBody($this->model))->render(),
            'iconClass'      => 'fa-check-square bg-yellow',
            'footerDatetime' => ArrayHelper::getValue($this->model, 'ins_ts'),
            'footer'         => ''
        ];

        return [$view, $params];
    }
}
