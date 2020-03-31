<?php

namespace common\services\Sms\models;

use common\services\Customer\models\Customer;
use common\services\User\models\User;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%sms}}".
 *
 * @property integer  $id
 * @property integer  $user_id
 * @property integer  $customer_id
 * @property integer  $status
 * @property string   $phone_from
 * @property string   $message
 * @property string   $ins_ts
 * @property integer  $direction
 * @property string   $phone_to
 * @property integer  $type
 * @property string   $formatted_message
 *
 * @property string   $statusText
 * @property string   $directionText
 *
 * @property Customer $customer
 * @property User     $user
 */
class Sms extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sms}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone_to', 'direction'], 'required'],
            [['user_id', 'customer_id', 'status', 'direction', 'applicant_id', 'type'], 'integer'],
            [['message'], 'string'],
            [['ins_ts'], 'safe'],
            [['phone_from', 'phone_to'], 'string', 'max' => 255],
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
            'id'            => Yii::t('app', 'ID'),
            'user_id'       => Yii::t('app', 'User ID'),
            'customer_id'   => Yii::t('app', 'Customer ID'),
            'status'        => Yii::t('app', 'Status'),
            'statusText'    => Yii::t('app', 'Status'),
            'phone_from'    => Yii::t('app', 'Phone From'),
            'phone_to'      => Yii::t('app', 'Phone To'),
            'message'       => Yii::t('app', 'Message'),
            'ins_ts'        => Yii::t('app', 'Date'),
            'direction'     => Yii::t('app', 'Direction'),
            'directionText' => Yii::t('app', 'Direction'),
            'user.fullname' => Yii::t('app', 'User'),
            'customer.name' => Yii::t('app', 'Client'),
        ];
    }
}
