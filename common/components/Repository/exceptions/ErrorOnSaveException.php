<?php

namespace common\components\Repository\exceptions;

use yii\base\Exception;
use yii\db\ActiveRecord;
use yii\db\ActiveRecordInterface;

/**
 * Class ErrorOnSaveException
 * @package common\services\Repository\exceptions
 */
class ErrorOnSaveException extends Exception
{
    /**
     * @var ActiveRecord
     */
    private $model;

    /**
     * ErrorOnSaveException constructor.
     *
     * @param ActiveRecord $model
     */
    public function __construct(ActiveRecordInterface $model)
    {
        $this->model = $model;
        $this->code = 500;
        parent::__construct(
            \Yii::t('app', 'Error while save model' . print_r($model->errors, true))
        );
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->model->getErrors();
    }

    /**
     * @return ActiveRecord
     */
    public function getModel()
    {
        return $this->model;
    }
}
