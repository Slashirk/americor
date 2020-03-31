<?php

namespace common\services\Sms\constants;

class SmsConstants
{
    const DIRECTION_INCOMING = 0;
    const DIRECTION_OUTGOING = 1;

    // incoming
    const STATUS_NEW      = 0;
    const STATUS_READ     = 1;
    const STATUS_ANSWERED = 2;

    // outgoing
    const STATUS_DRAFT     = 10;
    const STATUS_WAIT      = 11;
    const STATUS_SENT      = 12;
    const STATUS_DELIVERED = 13;
    const STATUS_FAILED    = 14;
    const STATUS_SUCCESS   = 13;
}
