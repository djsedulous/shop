<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\User;
use yii\console\Controller;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class RbacController extends Controller
{
    public function actionIndex()
    {
        $authManager = \Yii::$app->authManager;

        $user  = $authManager->createRole('user');
        $user->description = 'Base user role';

        $authManager->add($user);
    }

    public function actionAddPermission()
    {
        $authManager = \Yii::$app->authManager;
        $user  = $authManager->getRole('user');
        $createOrder = $authManager->createPermission('create_order');
        $authManager->add($createOrder);
        $authManager->addChild($user, $createOrder);
    }

    public function actionCreateAdmin()
    {
        $user = new User();

        $user->first_name = 'admin';
        $user->last_name = 'admin';
        $user->email = 'admin@test.com';
        $user->password = md5('admin');
        $user->phone = 'test';

        $user->save();
    }

    public function actionAssignmentRole()
    {
        $authManager = \Yii::$app->authManager;
        $user  = $authManager->getRole('user');
        $createOrder = $authManager->createPermission('create_order');
        $authManager->add($createOrder);
        $authManager->addChild($user, $createOrder);
    }

    public function actionCreateAdminRole(){
        $authManager = \Yii::$app->authManager;
        $admin = $authManager->createRole('admin');
        $authManager->add($admin);
        $user  = $authManager->getRole('user');
        $authManager->addChild($admin, $user);
    }

    public function actionAssignmentAdmin(){
        $authManager = \Yii::$app->authManager;

        $admin  = $authManager->getRole('admin');
        $authManager->assign($admin,1);
    }
}
