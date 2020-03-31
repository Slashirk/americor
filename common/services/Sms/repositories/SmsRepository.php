<?php

namespace common\services\Sms\repositories;

use common\components\Repository\classes\BaseRepository;
use common\services\Sms\models\Sms;

class SmsRepository extends BaseRepository
{
    public static $modelClass = Sms::class;
}
