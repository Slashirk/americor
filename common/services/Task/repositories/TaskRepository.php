<?php

namespace common\services\Task\repositories;

use common\components\Repository\classes\BaseRepository;
use common\services\Task\models\Task;

class TaskRepository extends BaseRepository
{
    public static $modelClass = Task::class;
}
