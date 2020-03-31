<?php

namespace common\services\User\repositories;

use common\components\Repository\classes\BaseRepository;
use common\services\User\models\User;

class UserRepository extends BaseRepository
{
    public static $modelClass = User::class;
}
