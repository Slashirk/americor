<?php

namespace common\services\History\constants;

/**
 * Class HistoryEventConstants
 * @package common\services\History\constants
 */
class HistoryEventConstants
{
    const EVENT_CREATED_TASK   = 'created_task';
    const EVENT_UPDATED_TASK   = 'updated_task';
    const EVENT_COMPLETED_TASK = 'completed_task';

    const EVENT_INCOMING_SMS = 'incoming_sms';
    const EVENT_OUTGOING_SMS = 'outgoing_sms';

    const EVENT_INCOMING_CALL = 'incoming_call';
    const EVENT_OUTGOING_CALL = 'outgoing_call';

    const EVENT_INCOMING_FAX = 'incoming_fax';
    const EVENT_OUTGOING_FAX = 'outgoing_fax';

    const EVENT_CUSTOMER_CHANGE_TYPE    = 'customer_change_type';
    const EVENT_CUSTOMER_CHANGE_QUALITY = 'customer_change_quality';
}
