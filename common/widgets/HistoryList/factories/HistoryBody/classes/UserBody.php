<?php

namespace common\widgets\HistoryList\factories\HistoryBody\classes;

use common\widgets\HistoryList\interfaces\HistoryListBodyInterface;

class UserBody implements HistoryListBodyInterface
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
     * @return string
     */
    public function render(): string
    {
        return '';
    }
}
