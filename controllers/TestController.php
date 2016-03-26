<?php

namespace app\controllers;

use app\models\Product;
use app\models\ProductStock;
use app\models\Stock;
use \Yii;

class TestController extends \yii\web\Controller
{

    public function actionIndex()
    {
        var_dump(Yii::$app->user->isAdmin);
    }

}
