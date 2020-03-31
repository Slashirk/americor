<?php

namespace common\components\Repository\exceptions;

use yii\base\Exception;

/**
 * Class ModelNotFoundException
 * @package common\services\Repository\exceptions
 */
class ModelNotFoundException extends Exception
{
    /**
     * @var int|array criteria to find model
     */
    private $criteria;

    /**
     * ModelNotFoundException constructor.
     * @param $criteria
     */
    public function __construct($criteria)
    {
        $this->criteria = $criteria;
        $this->code = 404;

        parent::__construct(\Yii::t('app', 'Model not found'));
    }

    /**
     * @return array|int
     */
    public function getCriteria()
    {
        return $this->criteria;
    }
}
