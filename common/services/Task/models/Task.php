<?php

namespace common\services\Task\models;

use common\services\Customer\models\Customer;
use common\services\User\models\User;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%task}}".
 *
 * @property integer  $id
 * @property integer  $user_id
 * @property integer  $customer_id
 * @property integer  $status
 * @property string   $title
 * @property string   $text
 * @property string   $due_date
 * @property integer  $priority
 * @property string   $ins_ts
 *
 * @property string   $stateText
 * @property string   $state
 * @property string   $subTitle
 *
 * @property boolean  $isOverdue
 * @property boolean  $isDone
 *
 * @property Customer $customer
 * @property User     $user
 *
 *
 * @property string   $isInbox
 * @property string   $statusText
 */
class Task extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%task}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'title'], 'required'],
            [['user_id', 'customer_id', 'status', 'priority'], 'integer'],
            [['text'], 'string'],
            [['title', 'object'], 'string', 'max' => 255],
            [
                ['customer_id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => Customer::className(),
                'targetAttribute' => ['customer_id' => 'id']
            ],
            [
                ['user_id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => User::className(),
                'targetAttribute' => ['user_id' => 'id']
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                 => Yii::t('app', 'ID'),
            'user_id'            => Yii::t('app', 'User'),
            'customer_id'        => Yii::t('app', 'Customer ID'),
            'status'             => Yii::t('app', 'Status'),
            'title'              => Yii::t('app', 'Title'),
            'text'               => Yii::t('app', 'Description'),
            'due_date'           => Yii::t('app', 'Due Date'),
            'formatted_due_date' => Yii::t('app', 'Due Date'),
            'priority'           => Yii::t('app', 'Priority'),
            'ins_ts'             => Yii::t('app', 'Ins Ts'),
        ];
    }
}
