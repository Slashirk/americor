<?php
use common\widgets\HistoryList\factories\HistoryObjects\HistoryObjectsFactory;

/** @var $model array */

[$view, $params] = (HistoryObjectsFactory::getObject($model))->get();

if (!empty($view)) {
    echo $this->render($view, $params);
}

