<?php

namespace common\widgets\HistoryList\factories\HistoryObjects\classes;

use common\widgets\HistoryList\interfaces\HistoryListObjectInterface;

class UserObject implements HistoryListObjectInterface
{
    /** @var array */
    private $model;

    /**
     * UserBody constructor.
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
        return [null, null];
    }
}
