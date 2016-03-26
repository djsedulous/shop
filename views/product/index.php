<?php
/**
 * Created by PhpStorm.
 * User: Viacheslav Matchenko
 * Date: 27.03.2016
 * Time: 0:17
 */

use yii\helpers\Html;

$this->title = 'Product Management Page';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php echo Html::a('Add Product', ['add'], ['class' => 'btn btn-success']); ?>

</div>
