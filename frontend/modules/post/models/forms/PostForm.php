<?php

namespace frontend\modules\post\models\forms;

use Yii;
use yii\base\Model;
use frontend\models\Post;
//use frontend\models\User;
use Intervention\Image\ImageManager;
//use frontend\models\events\PostCreatedEvent;

class PostForm extends Model
{

    const MAX_DESCRIPTION_LENGHT = 10000;
    
    /**
     * @var \yii\web\UploadedFile uploaded picture
     */
    public $picture;
    
    /**
     * @var string description of the picture
     */
    public $description;
    
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
            [['picture'], 'file',
                'skipOnEmpty' => true,
                'extensions' => ['jpg', 'png'],
                'checkExtensionByMimeType' => true,
                'maxSize' => $this->getMaxFileSize()],
            [['description'], 'string', 'max' => self::MAX_DESCRIPTION_LENGHT],
            [['description'], 'required', 'when' => function($model) { return $model->picture ? false : true; }, 'message' => 'Post can\'t be empty'],
        ];
    }
    
    /**
     * @param \frontend\models\User $user
     */
    public function __construct(\frontend\models\User $user)
    {
        $this->user = $user;
        $this->on(self::EVENT_AFTER_VALIDATE, [$this, 'resizePicture']);
    }

    /**
     * Resize image if needed
     */
    public function resizePicture()
    {
        $width = Yii::$app->params['postPicture']['maxWidth'];
        $height = Yii::$app->params['postPicture']['maxHeight'];

        $manager = new ImageManager(array('driver' => 'imagick'));

        $image = $manager->make($this->picture->tempName);     //    /tmp/12ty82

        $image->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->save();        //    /tmp/12ty82
    }
    
    /**
     * @return boolean
     */
    public function save() {
        if ($this->validate()) {
            $post = new Post();
            $post->author_id = $this->user->getId();
            $post->author_name = $this->user->username;
            $post->author_picture = $this->user->picture;
            
            /* @var $storage \frontend\components\Storage */
            $storage = Yii::$app->storage;
            $post->filename = $this->picture ? $storage->saveUploadedFile($this->picture) : null;
            
            $post->description = $this->description;
            $post->created_at = time();
            if ($post->save(false)) {
                $this->user->sendFeed($post);
                return true;
            }
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

