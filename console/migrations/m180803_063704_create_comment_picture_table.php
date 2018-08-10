<?php

use yii\db\Migration;

/**
 * Handles the creation of table `comment_picture`.
 */
class m180803_063704_create_comment_picture_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('comment_picture', [
            'id' => $this->primaryKey(),
            'comment_id' => $this->integer()->notNull(),
            'filename' => $this->string(),
        ]);
        
        $this->createIndex('idx_comment_id', 'comment_picture', 'comment_id');
        
        $this->addForeignKey('fk_comment_id', 'comment_picture', 'comment_id', 'comment', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('comment_picture');
    }
}
