<?php

namespace common\widgets\HistoryList\factories\HistoryObjects\classes;

use common\services\History\helpers\HistoryEventsHelper;
use common\widgets\HistoryList\factories\HistoryBody\HistoryBodyFactory;
use common\widgets\HistoryList\interfaces\HistoryListObjectInterface;
use yii\helpers\ArrayHelper;

class DefaultObject implements HistoryListObjectInterface
{
    /** @var array */
    private $model;

    /**
     * DefaultBody constructor.
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
            'user'         => ArrayHelper::getValue($this->model, ['relations', 'user']),
            'body'         => (HistoryBodyFactory::getBody($this->model))->render(),
            'bodyDatetime' => ArrayHelper::getValue($this->model, 'ins_ts'),
            'iconClass'    => 'fa-gear bg-purple-light'
        ];

        return [$view, $params];
    }
}
