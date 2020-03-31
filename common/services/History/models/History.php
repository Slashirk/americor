<?php

namespace common\services\History\models;

use common\traits\ObjectNameTrait;
use common\services\Customer\models\Customer;
use common\services\User\models\User;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%history}}".
 *
 * @property integer  $id
 * @property string   $ins_ts
 * @property integer  $customer_id
 * @property string   $event
 * @property string   $object
 * @property integer  $object_id
 * @property string   $message
 * @property string   $detail
 * @property integer  $user_id
 *
 * @property string   $eventText
 *
 * @property Customer $customer
 * @property User     $user
 */
class History extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%history}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ins_ts'], 'safe'],
            [['customer_id', 'object_id', 'user_id'], 'integer'],
            [['event'], 'required'],
            [['message', 'detail'], 'string'],
            [['event', 'object'], 'string', 'max' => 255],
            [
                ['customer_id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => Customer::class,
                'targetAttribute' => ['customer_id' => 'id']
            ],
            [
                ['user_id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => User::class,
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
            'id'          => Yii::t('app', 'ID'),
            'ins_ts'      => Yii::t('app', 'Ins Ts'),
            'customer_id' => Yii::t('app', 'Customer ID'),
            'event'       => Yii::t('app', 'Event'),
            'object'      => Yii::t('app', 'Object'),
            'object_id'   => Yii::t('app', 'Object ID'),
            'message'     => Yii::t('app', 'Message'),
            'detail'      => Yii::t('app', 'Detail'),
            'user_id'     => Yii::t('app', 'User ID'),
        ];
    }
}
