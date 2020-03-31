<?php

namespace common\widgets\HistoryList\factories\HistoryBody\constants;

use common\services\History\constants\HistoryObjectsConstants;
use common\widgets\HistoryList\factories\HistoryBody\classes\CallBody;
use common\widgets\HistoryList\factories\HistoryBody\classes\CustomerBody;
use common\widgets\HistoryList\factories\HistoryBody\classes\FaxBody;
use common\widgets\HistoryList\factories\HistoryBody\classes\SmsBody;
use common\widgets\HistoryList\factories\HistoryBody\classes\TaskBody;
use common\widgets\HistoryList\factories\HistoryBody\classes\UserBody;

class HistoryBodyFactoryConstants
{
    const LIST = [
        HistoryObjectsConstants::OBJECT_CUSTOMER => CustomerBody::class,
        HistoryObjectsConstants::OBJECT_USER     => UserBody::class,
        HistoryObjectsConstants::OBJECT_TASK     => TaskBody::class,
        HistoryObjectsConstants::OBJECT_SMS      => SmsBody::class,
        HistoryObjectsConstants::OBJECT_FAX      => FaxBody::class,
        HistoryObjectsConstants::OBJECT_CALL     => CallBody::class
    ];
}
