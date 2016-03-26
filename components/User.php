<?php
/**
 * Created by PhpStorm.
 * User: Viacheslav Matchenko
 * Date: 19.03.2016
 * Time: 14:32
 */

namespace app\components;


class User extends \yii\web\User
{
    public function getIsAdmin()
    {
        if (!$this->isGuest) {
            if ($this->getAuthManager()->checkAccess($this->id, 'admin')) {
                return true;
            }
        }

        return false;
    }
}