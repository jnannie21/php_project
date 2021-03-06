<?php

namespace frontend\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 * @property text $about
 * @property integer $type
 * @property string $picture
 */
class User extends ActiveRecord implements IdentityInterface {

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const DEFAULT_IMAGE = '/img/heroin.jpg';
    
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id) {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username) {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email) {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token) {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
                    'password_reset_token' => $token,
                    'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token) {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId() {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey() {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken() {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken() {
        $this->password_reset_token = null;
    }

    /**
     * Subscribe current user to given user
     * @param \frontend\models\User $user
     */
    public function followUser(User $user) {

        /* @var $redis \yii\redis\Connection */
        $redis = Yii::$app->redis;
        $redis->sadd("user:{$this->getId()}:subscriptions", $user->getId());
        $redis->sadd("user:{$user->getId()}:followers", $this->getId());
    }

    /**
     * Unsubscribe current user from given user
     * @param \frontend\models\User $user
     */
    public function unfollowUser(User $user) {

        /* @var $redis \yii\redis\Connection */
        $redis = Yii::$app->redis;
        $redis->srem("user:{$this->getId()}:subscriptions", $user->getId());
        $redis->srem("user:{$user->getId()}:followers", $this->getId());
    }

    public function getSubscriptions() {
        /* @var $redis \yii\redis\Connection */
        $redis = Yii::$app->redis;
        $key = "user:{$this->getId()}:subscriptions";
        $ids = $redis->smembers($key);
        return User::find()->select('id, username, email')->where(['id' => $ids, 'status' => self::STATUS_ACTIVE])->orderBy('username')->asArray()->all();
    }

    /**
     * 
     * @return array
     */
    public function getFollowers() {
        /* @var $redis \yii\redis\Connection */
        $redis = Yii::$app->redis;
        $key = "user:{$this->getId()}:followers";
        $ids = $redis->smembers($key);
        return User::find()->select('id, username, email')->where(['id' => $ids, 'status' => self::STATUS_ACTIVE])->orderBy('username')->asArray()->all();
    }

    /**
     * 
     * @param \frontend\models\User $user
     * @return array
     */
    public function getMutualSubscriptionsTo(User $user) {
        // Current user subscriptions
        $key1 = "user:{$this->getId()}:subscriptions";
        // Given user followers
        $key2 = "user:{$user->getId()}:subscriptions";
        
        /* @var $redis \yii\redis\Connection */
        $redis = Yii::$app->redis;
        
        $ids = $redis->sinter($key1, $key2);
        return User::find()->select('id, username, email')->where(['id' => $ids, 'status' => self::STATUS_ACTIVE])->orderBy('username')->asArray()->all();
    }

    /**
     * 
     * @return int
     */
    public function countSubscriptions() {
        /* @var $redis \yii\redis\Connection */
        $redis = Yii::$app->redis;
        return $redis->scard("user:{$this->getId()}:subscriptions");
    }

    /**
     * 
     * @return int
     */
    public function countFollowers() {
        /* @var $redis \yii\redis\Connection */
        $redis = Yii::$app->redis;
        return $redis->scard("user:{$this->getId()}:followers");
    }

    /**
     * Get profile picture
     * 
     * @return string picture path
     */
    public function getPicture(){
        if ($this->picture){
            return Yii::$app->storage->getFile($this->picture);
        }
        return self::DEFAULT_IMAGE;
    }
    
    /**
     * @param \frontend\models\Post $post post to send followers
     */
    public function sendFeed(Post $post) {
        /* @var $redis \yii\redis\Connection */
        $redis = Yii::$app->redis;
        $key = "user:{$this->id}:followers";
        $followers = $redis->smembers($key);

        if ($followers) {
            $timeRange = time() - Yii::$app->params['feedTTL'];

            foreach ($followers as $follower) {
                $redis->zadd("user:{$follower}:feed", $post->created_at, $post->id);
                $redis->zremrangebyscore("user:{$follower}:feed", '-inf', $timeRange);
            }
        }
    }
    
    /**
     * Get posts for feed
     * @param integer $limit
     * @return array
     */
    public function getFeed(int $limit)
    {
        $order = ['created_at' => SORT_DESC];
        $redis = Yii::$app->redis;
        $posts = $redis->zrangebyscore("user:{$this->id}:feed", '-inf', 'inf');

        return Post::find()->where(['id' => $posts])->orderBy($order)->limit($limit)->all();
    }
    
    /**
     * Check whether current user likes post with given id
     * @param integer $postId
     * @return boolean
     */
    public function likesPost(int $postId)
    {
        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        return (bool) $redis->sismember("user:{$this->getId()}:postLikes", $postId);
    }
    
    /**
     * Check whether current user likes post with given id
     * @param integer $postId
     * @return boolean
     */
    public function likesComment(int $commentId)
    {
        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        return (bool) $redis->sismember("user:{$this->getId()}:commentLikes", $commentId);
    }
    
    /**
     * Get post count
     * @return integer
     */
    public function getPostCount()
    {
        return $this->hasMany(Post::className(), ['user_id' => 'id'])->count();
    }

    /**
     * Get post count
     * @return Post[]
     */
    public function getPosts()
    {
        $order = ['created_at' => SORT_DESC];
        return $this->hasMany(Post::className(), ['user_id' => 'id'])->orderBy($order)->all();
    }
    
}
