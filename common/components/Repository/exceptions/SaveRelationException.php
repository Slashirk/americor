<?php

namespace common\components\Repository\exceptions;

use yii\base\Exception;

/**
 * Class SaveRelationException
 * @package common\services\Repository\exceptions
 */
class SaveRelationException extends Exception
{
    /**
     * SaveRelationException constructor.
     * @param int $code
     * @param string $message
     */
    public function __construct(int $code = 403, string $message = 'Cannot save relation')
    {
        parent::__construct($message, $code);
    }
}
