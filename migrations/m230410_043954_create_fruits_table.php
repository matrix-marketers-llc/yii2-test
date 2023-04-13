<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%fruits}}`.
 */
class m230410_043954_create_fruits_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%fruits}}', [
            'id' => $this->primaryKey(),
            'genus' => $this->string(30),
            'name' => $this->string(30)->unique(),
            'family' => $this->string(30),
            'order' => $this->string(30),
            'nutritions' => $this->string(),
            'is_favorite' =>  $this->boolean()->defaultValue(false)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%fruits}}');
    }
}
