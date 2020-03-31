<?php

namespace common\widgets\HistoryList\factories\HistoryObjects\constants;

use common\services\History\constants\HistoryObjectsConstants;
use common\widgets\HistoryList\factories\HistoryObjects\classes\CallObject;
use common\widgets\HistoryList\factories\HistoryObjects\classes\CustomerObject;
use common\widgets\HistoryList\factories\HistoryObjects\classes\FaxObject;
use common\widgets\HistoryList\factories\HistoryObjects\classes\SmsObject;
use common\widgets\HistoryList\factories\HistoryObjects\classes\TaskObject;
use common\widgets\HistoryList\factories\HistoryObjects\classes\UserObject;

class HistoryObjectsFactoryConstants
{
    const LIST = [
        HistoryObjectsConstants::OBJECT_CUSTOMER => CustomerObject::class,
        HistoryObjectsConstants::OBJECT_USER     => UserObject::class,
        HistoryObjectsConstants::OBJECT_TASK     => TaskObject::class,
        HistoryObjectsConstants::OBJECT_SMS      => SmsObject::class,
        HistoryObjectsConstants::OBJECT_FAX      => FaxObject::class,
        HistoryObjectsConstants::OBJECT_CALL     => CallObject::class
    ];
}
