<?php

namespace common\widgets\HistoryList\factories\HistoryObjects\classes;

use common\services\Sms\constants\SmsConstants;
use common\widgets\HistoryList\factories\HistoryBody\HistoryBodyFactory;
use common\widgets\HistoryList\interfaces\HistoryListObjectInterface;
use Yii;
use yii\helpers\ArrayHelper;

class SmsObject implements HistoryListObjectInterface
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
     * @return array
     */
    public function get(): array
    {
        $view = '_item_common';
        $params = [
            'user'           => ArrayHelper::getValue($this->model, ['relations', 'user']),
            'body'           => (HistoryBodyFactory::getBody($this->model))->render(),
            'footer'         => ArrayHelper::getValue($this->model,
                ['links', 'sms', 'direction']) == SmsConstants::DIRECTION_INCOMING
                ? Yii::t('app', 'Incoming message from {number}', ['number' => $model->sms->phone_from ?? ''])
                : Yii::t('app', 'Sent message to {number}', ['number' => $model->sms->phone_to ?? '']),
            'iconIncome'     => ArrayHelper::getValue($this->model,
                    ['links', 'sms', 'direction']) == SmsConstants::DIRECTION_INCOMING,
            'footerDatetime' => ArrayHelper::getValue($this->model, 'ins_ts'),
            'iconClass'      => 'icon-sms bg-dark-blue'
        ];

        return [$view, $params];
    }
}
