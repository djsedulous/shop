<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class RegistrationForm extends Model
{
    public $first_name;
    public $last_name;
    public $phone;
    public $email;
    public $password;
    public $confirm_password;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['first_name', 'last_name', 'email', 'password', 'phone', 'confirm_password'], 'required'],
            // password is validated by validatePassword()
            [['email'], 'unique', 'targetAttribute' => ['email'], 'targetClass' => User::className()],
            [['email'], 'email'],
            [['password', 'confirm_password'], 'string', 'length' => [6, 8]],
            [['confirm_password'], 'compare', 'compareAttribute' => 'password'],
        ];
    }


}