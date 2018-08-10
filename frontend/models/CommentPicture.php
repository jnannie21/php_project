<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "comment_picture".
 *
 * @property int $id
 * @property int $comment_id
 * @property string $filename
 *
 * @property Comment $comment
 */
class CommentPicture extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment_picture';
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'comment_id' => 'Comment ID',
            'filename' => 'Filename',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComment()
    {
        return $this->hasOne(Comment::className(), ['id' => 'comment_id']);
    }
}
