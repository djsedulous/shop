<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProductForm */
/* @var $form ActiveForm */

$this->title = 'Редактирование товара';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="site-product">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php foreach (Yii::$app->session->getAllFlashes() as $key => $flash) {
        echo \yii\bootstrap\Alert::widget(['options' => ['class' => 'alert-' . $key], 'body' => $flash]);
    }
    ?>

    <?php
    // Если сценарий редактирование
    if ($model->scenario == \app\models\ProductForm::SCENARIO_EDIT) {
    /**
     * @var \app\models\Product $product
     */

    ?>
    <div class="col-lg-5 no-padding">
        <?php
        $image = $product->getMainImage();

        if ($image) {
            echo Html::img(\app\models\MultiUploadForm::getImageUrl($image), [
                'width' => '100%',
                'class' => 'img-thumbnail'
            ]);
        }
        ?>

        <hr>

        <?php
        // Проходимся по картинкам данного продукта (идет обращение к БД, когда вызываем $product->images)
        // Это прелести фреймфорка, удобно - быстро
        foreach ($product->images as $image) {

            // Выводим тег img
            echo Html::img(\app\models\MultiUploadForm::getImageUrl($image->name), [
                'width' => '75px',
//                    'style' => 'margin: 2px;'
                'class' => 'img-thumbnail'
            ]);
        }

        ?>
    </div>
    <div class="col-lg-7 no-padding-right">
        <?php
        } else {
        ?>
        <div class="col-lg-12 no-padding">
            <?php } ?>
            <div class="panel panel-default">
                <div class="panel-heading">Редактирование товара</div>
                <div class="panel-body">
                    <?php $form = ActiveForm::begin([
                        'options' => ['enctype' => 'multipart/form-data']
                    ]); ?>

                    <?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>
                    <?= $form->field($model, 'name') ?>
                    <?= $form->field($model, 'price') ?>
                    <?= $form->field($model, 'guarantee') ?>

                    <div class="form-group">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>


    </div><!-- site-product -->
