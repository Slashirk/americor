<?php

namespace common\widgets\HistoryList\interfaces;

interface HistoryListBodyInterface
{
    public function __construct(array $model);

    public function render(): string;
}
