<?php

use yii\db\Migration;

/**
 * Class m180714_165400_alter_post_table
 */
class m180714_165400_alter_post_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('{{%post}}', 'user_id', 'author_id');
        $this->addColumn('{{%post}}', 'author_name', $this->string()->notNull()->after('author_id'));
        $this->addColumn('{{%post}}', 'author_picture', $this->string()->after('author_name'));
        
        $sql = 'update post p set author_name = (select username from user u where u.id = p.author_id);';
        Yii::$app->db->createCommand($sql)->execute();
        $sql = 'update post p set author_picture = (select picture from user u where u.id = p.author_id);';
        Yii::$app->db->createCommand($sql)->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('{{%post}}', 'author_id', 'user_id');
        $this->dropColumn('{{%post}}', 'author_name');
        $this->dropColumn('{{%post}}', 'author_picture');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180714_165400_alter_post_table cannot be reverted.\n";

        return false;
    }
    */
}
