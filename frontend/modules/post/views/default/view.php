<?php
/* @var $this yii\web\View */
/* @var $currentUser frontend\models\User */
/* @var $post frontend\models\Post */

use yii\web\JqueryAsset;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

$this->title = 'Post';
?>

<div class="page-posts">

                <div class="post">

                    <div class="post-title">
                        <p><?php echo HtmlPurifier::process($post->description); ?></p>
                    </div>
                    <div class="post-type-image">
                            <img src="<?php echo $post->getImage(); ?>" alt="" />  
                    </div>
                    <div class="post-description">
                        <p><?php echo HtmlPurifier::process($post->description); ?></p>
                    </div>
                    <div class="post-bottom">
                        <div class="post-meta">
                            <img src="<?php echo Yii::$app->storage->getFile($post->author_picture); ?>" class="author-image"/>
                            <div class="author-name">
                                <a href="<?php echo Url::to(['/user/profile/view', 'username' => $post->author_name]); ?>">
                                    <?php echo Html::encode($post->author_name); ?>
                                </a>
                            </div>
                        </div>
                        <div class="post-likes">
                            <a href="#!" class="button-like" data-id="<?php echo $post->id; ?>">
                                <?php echo ($currentUser->likesPost($post->id)) ? "Unlike" : "Like"; ?>
                                <span class="glyphicon <?php echo ($currentUser->likesPost($post->id)) ? "glyphicon glyphicon-thumbs-down" : "glyphicon glyphicon-thumbs-up"; ?>"></span>
                            </a>
                            
                            <span class="likes-count"><?php echo $post->countLikes(); ?></span>
                        </div>
                        <div class="post-comments">
                            <a href="#!">0 Comments</a>
                        </div>
                        <div class="post-bottom-right">
                            <div class="post-date">
                                <span><?php echo Yii::$app->formatter->asDatetime($post->created_at, 'php: j M Y h:i'); ?></span>    
                            </div>
                            <div class="post-report">
                                <?php if (!$post->isReported($currentUser)): ?>
<!--                                    <a href="#!" class="btn btn-default button-complain" data-id="<?php echo $post->id; ?>">
                                        Report post <i class="glyphicon glyphicon-refresh icon-preloader" style="display:none"></i>
                                    </a>-->
                                <?php else: ?>
                                    <p>Post has been reported</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <br><br><br>
                </div>

</div>



<?php
$this->registerJsFile('@web/js/likes.js', [
    'depends' => JqueryAsset::className(),
]);
//$this->registerJsFile('@web/js/complaints.js', [
//    'depends' => JqueryAsset::className(),
//]);
