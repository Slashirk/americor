<?php

namespace common\services\Task\constants;

class TaskConstants
{
    const STATUS_NEW    = 0;
    const STATUS_DONE   = 1;
    const STATUS_CANCEL = 3;

    const STATE_INBOX  = 'inbox';
    const STATE_DONE   = 'done';
    const STATE_FUTURE = 'future';
}
