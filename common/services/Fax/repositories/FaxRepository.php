<?php

namespace common\services\Fax\repositories;

use common\components\Repository\classes\BaseRepository;
use common\services\Fax\models\Fax;

class FaxRepository extends BaseRepository
{
    public static $modelClass = Fax::class;
}
