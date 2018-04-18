<?php

use yii\db\Migration;

/**
 * Handles the creation of table `post`.
 */
class m180418_043857_create_post_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('post', [
            'id' => $this->primaryKey(),
            'user_id'=>$this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'body' => $this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('post');
    }
}
