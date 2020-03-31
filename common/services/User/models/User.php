<?php

namespace common\services\User\models;

use common\services\User\constants\UserConstants;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property string  $username
 * @property string  $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class User extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'created_at', 'updated_at'], 'required'],
            [
                [
                    'status',
                    'created_at',
                    'updated_at',
                ],
                'integer'
            ],
            [
                [
                    'username',
                    'email',
                ],
                'string',
                'max' => 255
            ],

            [['username'], 'unique'],

            ['status', 'default', 'value' => UserConstants::STATUS_ACTIVE],
            [
                'status',
                'in',
                'range' => [UserConstants::STATUS_ACTIVE, UserConstants::STATUS_DELETED, UserConstants::STATUS_HIDDEN]
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => Yii::t('app', 'ID'),
            'username'   => Yii::t('app', 'Username (login)'),
            'statusText' => Yii::t('app', 'Status'),
        ];
    }
}
