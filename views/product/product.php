<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProductForm */
/* @var $form ActiveForm */
?>

<div class="col-lg-12">
    <?php foreach (Yii::$app->session->getAllFlashes() as $key => $flash) {
        echo \yii\bootstrap\Alert::widget(['options' => ['class' => 'alert-' . $key], 'body' => $flash]);
    }
    ?>


    <div class="site-product">

        <?php
        // Если сценарий редактирование
        if ($model->scenario == \app\models\ProductForm::SCENARIO_EDIT) {
            /**
             * @var \app\models\Product $product
             */

            // Проходимся по картинкам данного продукта (идет обращение к БД, когда вызываем $product->images)
            // Это прелести фреймфорка, удобно - быстро
            foreach ($product->images as $image) {
                // Выводим тег img
                echo Html::img(\app\models\MultiUploadForm::getImageUrl($image->name), [
                    'height' => '150px',
                ]);
            }
        }
        ?>

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

    </div><!-- site-product -->

</div>