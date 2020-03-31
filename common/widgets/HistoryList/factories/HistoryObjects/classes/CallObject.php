<?php

namespace common\widgets\HistoryList\factories\HistoryObjects\classes;

use common\services\Call\constants\CallConstants;
use common\widgets\HistoryList\factories\HistoryBody\HistoryBodyFactory;
use common\widgets\HistoryList\interfaces\HistoryListObjectInterface;
use yii\helpers\ArrayHelper;

class CallObject implements HistoryListObjectInterface
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
     * @return array
     */
    public function get(): array
    {
        $view = '_item_common';

        $call = ArrayHelper::getValue($this->model, ['links', 'call']);
        $answered = $call && $call['status'] == CallConstants::STATUS_ANSWERED;

        $params = [
            'user'           => ArrayHelper::getValue($this->model, ['relations', 'user']),
            'content'        => ArrayHelper::getValue($call, 'comment', ''),
            'body'           => (HistoryBodyFactory::getBody($this->model))->render(),
            'footerDatetime' => ArrayHelper::getValue($this->model, 'ins_ts'),
            'footer'         => null,
            'iconClass'      => $answered ? 'md-phone bg-green' : 'md-phone-missed bg-red',
            'iconIncome'     => $answered
                && ArrayHelper::getValue($call, 'direction') == CallConstants::DIRECTION_INCOMING
        ];

        return [$view, $params];
    }
}
