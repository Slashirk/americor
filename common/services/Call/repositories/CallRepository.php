<?php

namespace common\services\Call\repositories;

use common\components\Repository\classes\BaseRepository;
use common\services\Call\models\Call;

class CallRepository extends BaseRepository
{
    public static $modelClass = Call::class;
}
