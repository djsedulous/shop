<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $last_name
 * @property string $first_name
 * @property string $date_reg
 * @property string $phone
 * @property string $email
 * @property string $password
 *
 * @property Order[] $orders
 * @property Order[] $orders0
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['last_name', 'first_name', 'phone', 'email'], 'required'],
            [['date_reg'], 'safe'],
            [['last_name', 'first_name', 'email'], 'string', 'max' => 45],
            [['phone'], 'string', 'max' => 14],
            [['password'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'last_name' => 'Last Name',
            'first_name' => 'First Name',
            'date_reg' => 'Date Reg',
            'phone' => 'Phone',
            'email' => 'Email',
            'password' => 'Password',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['manager_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders0()
    {
        return $this->hasMany(Order::className(), ['client_id' => 'id']);
    }
}
