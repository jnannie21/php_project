<?php

namespace frontend\models;

use Yii;
use frontend\models\User;

/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property integer $author_id
 * @property string $author_name
 * @property string $author_picture
 * @property string $filename
 * @property string $description
 * @property integer $created_at
 */
class Post extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author_name' => 'Author name',
            'author_picture' => 'Author picture',
            'author_id' => 'Author ID',
            'filename' => 'Filename',
            'description' => 'Description',
            'created_at' => 'Created At',
        ];
    }

    public function getImage()
    {
        return Yii::$app->storage->getFile($this->filename);
    }

    /**
     * Get author of the post
     * @return User|null
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }
    
    /**
     * Like current post by given user
     * @param \frontend\models\User $user
     */
    public function like(User $user)
    {
        /* @var $redis yii\redis\Connection */
        $redis = Yii::$app->redis;
        $redis->sadd("post:{$this->getId()}:likes", $user->getId());
        $redis->sadd("user:{$user->getId()}:likes", $this->getId());
    }
    
    /**
     * Unlike current post by given user
     * @param \frontend\models\User $user
     */
    public function unLike(User $user)
    {
        /* @var $redis yii\redis\Connection */
        $redis = Yii::$app->redis;
        $redis->srem("post:{$this->getId()}:likes", $user->getId());
        $redis->srem("user:{$user->getId()}:likes", $this->getId());
    }
    
    /**
     * @return integer post ID
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @return mixed
     */
    public function countLikes()
    {
        /* @var $redis yii\redis\Connection */
        $redis = Yii::$app->redis;
        return $redis->scard("post:{$this->getId()}:likes");
    }
    
    /**
     * Check whether given user liked current post
     * @param \frontend\models\User $user
     * @return integer 1 or 0
     */
    public function isLikedBy(User $user)
    {
        /* @var $redis yii\redis\Connection */
        $redis = Yii::$app->redis;
        return $redis->sismember("post:{$this->getId()}:likes", $user->getId());
    }

    /**
     * Add complaint to post from given user
     * @param \frontend\models\User $user
     * @return boolean
     */
    public function complain(User $user)
    {
        /* @var $redis yii\redis\Connection */
        $redis = Yii::$app->redis;
        $key = "post:{$this->getId()}:complaints";
        
        if (!$redis->sismember($key, $user->getId())) {
            $redis->sadd($key, $user->getId());        
            $this->complaints++;
            return $this->save(false, ['complaints']);
        }
    }
    
    public function isReported(User $user)
    {
        /* @var $redis yii\redis\Connection */
        $redis = Yii::$app->redis;
        return $redis->sismember("post:{$this->id}:complaints", $user->getId());
    }
}
