<?php
/* @var $this yii\web\View */
?>
<h1>test/index</h1>

<p>
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>.
</p>

<pre>
    <?php

    foreach($products as $product) {
        print_r($product->toArray());
    }

    ?>
</pre>