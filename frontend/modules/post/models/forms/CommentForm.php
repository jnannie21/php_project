<?php

namespace frontend\modules\post\models\forms;

use Yii;
use yii\base\Model;
use frontend\models\Comment;
use frontend\models\Post;
//use frontend\models\User;
use Intervention\Image\ImageManager;

class CommentForm extends Model
{

    const MAX_DESCRIPTION_LENGHT = 2000;
    /**
     *
     * @var integer post ID
     */
    public $post_id;
    
    /**
     *
     * @var integer parent comment ID
     */
    public $parent_id;
    
    /**
     * @var \yii\web\UploadedFile uploaded picture
     */
    public $picture;
    
    /**
     * @var string text content of the comment
     */
    public $content;
    
    /**
     *
     * @var \frontend\models\Comment saved comment
     */
    public $comment;
    
    /**
     * @var \frontend\models\User Yii::$app->user->identity
     */
    private $user;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id'], 'required'],
            [['post_id', 'parent_id'], 'integer'],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Comment::className(), 'targetAttribute' => ['parent_id' => 'id']],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['post_id' => 'id']],
            [['picture'], 'file',
                'skipOnEmpty' => true,
                'extensions' => ['jpg', 'png'],
                'checkExtensionByMimeType' => true,
                'maxSize' => $this->getMaxFileSize()],
            [['content'], 'required', 'when' => function($model) { return $model->picture ? false : true; }, 'message' => 'Comment can\'t be empty'],
            [['content'], 'string', 'max' => self::MAX_DESCRIPTION_LENGHT],
        ];
    }
    
    /**
     * @param \frontend\models\User $user
     */
    public function __construct(\frontend\models\User $user = null)
    {
        $this->user = $user;
        $this->on(self::EVENT_AFTER_VALIDATE, [$this, 'resizePicture']);
    }

    /**
     * Resize image if needed
     */
    public function resizePicture() {
        if ($this->picture) {
            $width = Yii::$app->params['postPicture']['maxWidth'];
            $height = Yii::$app->params['postPicture']['maxHeight'];

            $manager = new ImageManager(array('driver' => 'imagick'));

            $image = $manager->make($this->picture->tempName);     //    /tmp/12ty82

            $image->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save();        //    /tmp/12ty82
        }
    }

    /**
     * @return boolean
     */
    public function save() {
        if ($this->validate()) {
            $comment = new Comment();
            $comment->post_id = $this->post_id;
            $comment->author_id = $this->user->getId();
            $comment->author_name = $this->user->username;
            $comment->author_picture = $this->user->picture;
            
            /* @var $storage \frontend\components\Storage */
            $storage = Yii::$app->storage;
            $comment->filename = $this->picture ? $storage->saveUploadedFile($this->picture) : null;
            $comment->content = $this->content;
            $comment->created_at = time();
            $comment->parent_id = $this->parent_id;
            $comment->post->comments_count++;
            $this->comment = $comment;
            
            return Yii::$app->getDb()->transaction(function($db) use ($comment) {
                if ($comment->save(false) && $comment->post->save(false, ['comments_count'])) {
                    return true;
                }
                return false;
            });
        }
        return false;
    }

    /**
     * Maximum size of the uploaded file
     * @return integer
     */
    private function getMaxFileSize()
    {
        return Yii::$app->params['maxFileSize'];
    }
}

