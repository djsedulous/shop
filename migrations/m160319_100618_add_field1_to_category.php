<?php

use yii\db\Migration;

class m160319_100618_add_field1_to_category extends Migration
{
    public function up()
    {
        $this->addColumn('category', 'field1', $this->text());
    }

    public function down()
    {
        $this->dropColumn('category', 'field1');
    }
}
