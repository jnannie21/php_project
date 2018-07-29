<?php

use yii\db\Migration;

/**
 * Handles the creation of table `comment`.
 */
class m180725_111522_create_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('comment', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull(),
            'author_name' => $this->string()->notNull(),
            'author_picture' => $this->string(),
            'filename' => $this->string(),
            'content' => $this->text(),
            'created_at' => $this->integer()->notNull(),
            'parent_id' => $this->integer(),
            'rating' => $this->integer(),
        ]);
        
        $this->createIndex('idx_post_id', 'comment', 'post_id');
        $this->createIndex('idx_author_id', 'comment', 'author_id');
        $this->createIndex('idx_parent_id', 'comment', 'parent_id');

        $this->addForeignKey('fk_post_id', 'comment', 'post_id', 'post', 'id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('fk_author_id', 'comment', 'author_id', 'user', 'id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('fk_parent_id', 'comment', 'parent_id', 'comment', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('comment');
    }
}
