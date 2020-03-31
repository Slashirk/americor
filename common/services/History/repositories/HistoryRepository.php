<?php

namespace common\services\History\repositories;

use common\components\Repository\classes\BaseRepository;
use common\services\Call\models\Call;
use common\services\Customer\models\Customer;
use common\services\Fax\models\Fax;
use common\services\History\constants\HistoryObjectsConstants;
use common\services\History\models\History;
use common\services\Sms\models\Sms;
use common\services\Task\models\Task;
use common\services\User\models\User;

class HistoryRepository extends BaseRepository
{
    /** @var string */
    public static $modelClass = History::class;

    /** @var array */
    public static $relations = [
        HistoryObjectsConstants::OBJECT_CUSTOMER => ['modelClass' => Customer::class, 'attributeName' => 'customer_id'],
        HistoryObjectsConstants::OBJECT_USER     => ['modelClass' => User::class, 'attributeName' => 'user_id'],
    ];

    /** @var string */
    public static $linkField = 'object';

    /** @var string */
    public static $linkFieldId = 'object_id';

    /** @var array */
    public static $links = [
        HistoryObjectsConstants::OBJECT_CALL     => ['modelClass' => Call::class],
        HistoryObjectsConstants::OBJECT_FAX      => ['modelClass' => Fax::class],
        HistoryObjectsConstants::OBJECT_SMS      => ['modelClass' => Sms::class],
        HistoryObjectsConstants::OBJECT_TASK     => ['modelClass' => Task::class],
        HistoryObjectsConstants::OBJECT_CUSTOMER => ['modelClass' => Customer::class]
    ];

    /**
     * @param int $start
     * @param int $limit
     *
     * @return array
     */
    public function getListOrderedById(int $start, int $limit): array
    {
        $models = $this->find()
            ->where(['>', 'id', $start])
            ->orderBy(['id' => SORT_ASC])
            ->limit($limit)
            ->asArray()
            ->all();

        $models = $this->getRelated($models);
        $models = $this->getLinked($models);

        return $models;
    }

    /**
     * @return mixed
     */
    public function getListMaxId()
    {
        return $this->find()->max('id');
    }

    /**
     * @param int $start
     * @param int $limit
     *
     * @return mixed
     */
    public function getListPrevId(int $start, int $limit)
    {
        $list = $this->find()
            ->select(['id'])
            ->where(['<=', 'id', $start])
            ->orderBy(['id' => SORT_DESC])
            ->limit($limit + 1)
            ->column();

        return end($list) ?? -1;
    }
}
