<?php

namespace common\services\History\bootstrap;

use common\services\History\repositories\HistoryRepository;
use common\services\History\services\HistoryService;
use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;

/**
 * Class HistoryBootstrap
 * @package common\services\History\bootstrap
 */
class HistoryBootstrap implements BootstrapInterface
{
    /**
     * @param Application $app
     */
    public function bootstrap($app)
    {
        Yii::$container->setSingletons([
            HistoryService::class,
            HistoryRepository::class
        ]);
    }
}