<?php

namespace common\widgets\HistoryList\interfaces;

interface HistoryListObjectInterface
{
    public function __construct(array $model);

    public function get(): array;
}