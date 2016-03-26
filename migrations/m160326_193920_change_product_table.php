<?php

use yii\db\Migration;

class m160326_193920_change_product_table extends Migration
{
    private $tableName;
    public function init()
    {
        parent::init();

        $this->tableName = \app\models\Product::tableName();
    }

    public function up()
    {
        $this->alterColumn($this->tableName, 'price', "DECIMAL(14,2) NULL DEFAULT '0'");
        $this->alterColumn($this->tableName, 'guarantee', "TINYINT(1) NULL DEFAULT NULL");
    }

    public function down()
    {
        echo "m160326_193920_change_product_table cannot be reverted.\n";
        $this->alterColumn($this->tableName, 'price', "DECIMAL(14,2) NOT NULL");
        $this->alterColumn($this->tableName, 'guarantee', "TINYINT(1) NOT NULL");
    }
}
