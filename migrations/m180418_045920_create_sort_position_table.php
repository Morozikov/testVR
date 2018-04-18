<?php

use yii\db\Migration;

/**
 * Handles the creation of table `sort_position`.
 */
class m180418_045920_create_sort_position_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('sort_position', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->unique(),
            'post_id_position' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('sort_position');
    }
}
