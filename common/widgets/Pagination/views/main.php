<?php
/** @var $start */
/** @var $end */
/** @var $max */
/** @var $prev */

use yii\helpers\Html;
use yii\helpers\Url;

echo Html::a(
    '<<',
    Url::to(['site/index']),
    [
        'class' => 'btn btn-primary'
    ]
);

echo ' ';

echo Html::a(
    '<',
    Url::to(['site/index', 'start' => $prev]),
    [
        'class' => 'btn btn-primary'
    ]
);

if ($end < $max) {
    echo ' ';
    echo Html::a(
        '>',
        Url::to(['site/index', 'start' => $end]),
        [
            'class' => 'btn btn-primary'
        ]
    );

}
?>