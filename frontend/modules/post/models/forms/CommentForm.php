<?php

namespace frontend\modules\post\models\forms;

use Yii;
use yii\base\Model;
use frontend\models\Comment;
use frontend\models\Post;
use frontend\models\CommentPicture;
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
     * @var \yii\web\UploadedFile[] uploaded pictures
     */
    public $pictures;
    
    /**
     *
     * @var \frontend\models\CommentPicture[] array of ActiveRecord for pictures
     */
    public $commentPictures;
    
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
            [['pictures'], 'file',
                'skipOnEmpty' => true,
                'skipOnError' => true,
                'extensions' => ['jpg', 'png'],
                'checkExtensionByMimeType' => true,
                'maxFiles' => 0,
                'maxSize' => $this->getMaxFileSize()],
            [['content'], 'required'], //'when' => function($model) { return $model->pictures ? false : true; }, 'message' => 'Comment can\'t be empty'],
            [['content'], 'string', 'max' => self::MAX_DESCRIPTION_LENGHT],
            [['content'], 'filter', 'filter'=> function($content) {return \yii\helpers\HtmlPurifier::process($content, ['HTML.Allowed' => 'img[src], div, br', 'Attr.DefaultImageAlt'=> 'Comment picture']);}],
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
        if ($this->pictures) {
            foreach ($this->pictures as $picture) {
                if ($picture->error) {continue;}
                $width = Yii::$app->params['postPicture']['maxWidth'];
                $height = Yii::$app->params['postPicture']['maxHeight'];

                $manager = new ImageManager(array('driver' => 'imagick'));

                $image = $manager->make($picture->tempName);     //    /tmp/12ty82

                $image->resize($width, $height, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save();        //    /tmp/12ty82
            }
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
            
            if ($this->pictures) {
                $this->commentPictures = $this->savePicturesToStorage($this->pictures, $this->content);
                if ($this->commentPictures) {
                    $comment->filename = Comment::HAS_PICTURES;
                }
            }
                        
            $comment->content = $this->prepareContent($this->content, $this->commentPictures);
            $comment->created_at = time()+10800;    //+3 hours
            $comment->parent_id = $this->parent_id;
            $comment->post->comments_count++;
            
            return $this->saveComment($comment);
        }
        return false;
    }

    /**
     * Maximum size of the uploaded file
     * @return integer
     */
    public function getMaxFileSize()
    {
        return Yii::$app->params['maxFileSize'];
    }
    

    /**
     * 
     * @param Comment $comment
     * @return bool is saved successful
     */
    private function saveComment(Comment $comment) {
        return Yii::$app->getDb()->transaction(function($db) use ($comment) {
            if ($comment->save(false) && $comment->post->save(false, ['comments_count'])) {
                $this->comment = $comment;
                if ($this->commentPictures) {
                    foreach ($this->commentPictures as $commentPicture) {
                        $commentPicture->comment_id = $comment->id;
                        $commentPicture->save(false);
                    }
                }
                return true;
            }
            return false;
        });
    }

    /**
     * 
     * @param \yii\web\UploadedFile[] $pictures uploaded files
     * @param string $content comment content
     * @return array array of ActiveRecord comment pictures
     */
    private function savePicturesToStorage($pictures, $content) {
            /* @var $storage \frontend\components\Storage */
            $storage = Yii::$app->storage;
            
            $commentPictures = [];
            
            $imgCount = preg_match_all('|<img[^>]*src="".*>|U', $content);
            foreach ($pictures as $picture) {
                if (!$imgCount) { return $commentPictures; }
                    $commentPicture = new CommentPicture();
                    $commentPicture->filename = $storage->saveUploadedFile($picture);
                    $commentPictures[] = $commentPicture;
                    $imgCount--;
            }
            return $commentPictures;
    }
    
    /**
     * Puts <img src=""> with saved images in content
     * 
     * @param string comment $content
     * @param \frontend\models\CommentPicture[] $commentPictures
     * @return string processed comment content
     */
    private function prepareContent($content, $commentPictures) {
        $content = $this->deleteEmptyDivs($content);
        
        if ($commentPictures) {
            $imgPlaceHolder = '{{img}}';
            $content = preg_replace('|<img[^>]*src="".*>|U', $imgPlaceHolder, $content);
            foreach ($commentPictures as $commentPicture) {
                $file = Yii::$app->storage->getFile($commentPicture->filename);
                $img = '<img src="'.$file.'" alt="Comment picture">';
                $content = $this->str_replace_once($imgPlaceHolder, $img, $content);
            }
        }
        return $content;
    }
    
    
    private static function str_replace_once($search, $replace, $text) 
    { 
       $pos = strpos($text, $search);
       return $pos!==false ? substr_replace($text, $replace, $pos, strlen($search)) : $text; 
    }
    
    private function deleteEmptyDivs($content){
        $content = preg_replace('|<div></div>|U', '', $content);
        return $content;
    }
        
}

