<?php

namespace common\widgets\HistoryList\factories\HistoryObjects\classes;

use common\services\Fax\helpers\FaxHelper;
use common\widgets\HistoryList\factories\HistoryBody\HistoryBodyFactory;
use common\widgets\HistoryList\interfaces\HistoryListObjectInterface;
use Yii;
use yii\helpers\ArrayHelper;

class FaxObject implements HistoryListObjectInterface
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
     * @return array
     */
    public function get(): array
    {
        $view = '_item_common';

        $fax = ArrayHelper::getValue($this->model, ['links', 'fax']);
        $params = [
            'user'           => ArrayHelper::getValue($this->model, ['relations', 'user']),
            'body'           => (HistoryBodyFactory::getBody($this->model))->render() .
                ' - ' .
                (isset($fax['document']) ? \yii\helpers\Html::a(
                    Yii::t('app', 'view document'),
                    '',
                    [
                        'target'    => '_blank',
                        'data-pjax' => 0
                    ]
                ) : ''),
            'footer'         => Yii::t('app', '{type} was sent to {group}', [
                'type'  => $fax ? FaxHelper::getTypeText($fax) : 'Fax',
                'group' => ''
            ]),
            'footerDatetime' => ArrayHelper::getValue($this->model, 'ins_ts'),
            'iconClass'      => 'fa-fax bg-green'
        ];

        return [$view, $params];
    }
}
