<?php

use yii\db\Migration;

class m160326_194802_create_product_image_tables extends Migration
{
    public function up()
    {
        $this->createTable('image', [
            'id' => $this->primaryKey(),
            'name' => 'VARCHAR(32)'
        ]);
        
        $this->createTable('product_image', [
            'product_id' => 'INT(11) NOT NULL',
            'image_id' => 'INT(11) NOT NULL',
            'is_main' => "TINYINT(1) NULL DEFAULT '0'",
        ]);
        
        $this->addPrimaryKey('product_id', 'product_image', ['product_id', 'image_id']);
        $this->createIndex('image_id', 'product_image', 'image_id');
        $this->addForeignKey('product_image_fk1', 'product_image', 'product_id', 'product', 'id', 'CASCADE');
        $this->addForeignKey('product_image_fk2', 'product_image', 'image_id', 'image', 'id', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('product_image');
        $this->dropTable('image');
    }
}
