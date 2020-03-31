<?php

namespace common\widgets\HistoryList;

use app\widgets\Export\Export;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class HistoryList extends Widget
{
    public $provider;

    public function run()
    {
        return $this->render('main', [
            'linkExport'   => $this->getLinkExport(),
            'dataProvider' => $this->provider
        ]);
    }

    /**
     * @return string
     */
    private function getLinkExport()
    {
        $params = \Yii::$app->getRequest()->getQueryParams();
        $params = ArrayHelper::merge([
            'exportType' => Export::FORMAT_CSV
        ], $params);
        $params[0] = 'site/export';

        return Url::to($params);
    }
}
