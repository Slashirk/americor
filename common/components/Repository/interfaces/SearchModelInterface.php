<?php

namespace common\components\Repository\interfaces;

use yii\data\BaseDataProvider;

interface SearchModelInterface
{
    public function search($params): BaseDataProvider;
}
