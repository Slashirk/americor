<?php

namespace common\services\Customer\repositories;

use common\components\Repository\classes\BaseRepository;
use common\services\Customer\models\Customer;

class CustomerRepository extends BaseRepository
{
    public static $modelClass = Customer::class;
}
