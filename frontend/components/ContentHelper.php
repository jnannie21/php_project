<?php

namespace frontend\components;

use Yii;
use frontend\models\CommentPicture;

class ContentHelper extends Component {
    
    public static function processContent($content) {
        $imgPlaceholder = self::getImgPlaceholder();
        $imgCount = null;
        $content = preg_replace('|<img.*>|U', $imgPlaceholder, $content, -1, $imgCount);
        $content = preg_replace('|<div.*>|U', '\n', $content);
        $content = preg_replace('|</div.*>|U', '', $content);
        $content = preg_replace('|<br.*>|U', '\n', $content);
        return [$content, $imgCount];
    }
    
    
    public static function getPreparedContent($content, CommentPicture $commentPictures) {
        if ($commentPictures) {
            foreach ($commentPictures as $commentPicture) {
                $file = Yii::$app->storage->getFile($commentPicture->filename);
                $img = '<img src="'.$file.'" >';
                $imgPlaceholder = self::getImgPlaceholder();
                $content = self::str_replace_once($imgPlaceholder, $img, $content);
            }
        }
        $content = str_replace('\n', '<br>', $content);
        return $content;
    }
    
    
    public static function getImgPlaceholder(){
        return Yii::$app->params['imgPlaceholder'];
    }
    
    
    /**
     * 
     * the same as str_replace() but once
     */
    public static function str_replace_once($search, $replace, $text) 
    { 
       $pos = strpos($text, $search);
       return $pos!==false ? substr_replace($text, $replace, $pos, strlen($search)) : $text; 
    }
}