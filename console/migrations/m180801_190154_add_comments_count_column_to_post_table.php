<?php

use yii\db\Migration;

/**
 * Handles adding comments_count to table `post`.
 */
class m180801_190154_add_comments_count_column_to_post_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('post', 'comments_count', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('post', 'comments_count');
    }
}
