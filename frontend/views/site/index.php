<?php
/* @var $this yii\web\View */
/* @var $currentUser frontend\models\User */
/* @var $feedItems[] frontend\models\Post */

use yii\web\JqueryAsset;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

$this->title = 'Newsfeed';
?>

<div class="page-posts">
    <div class="right-row-posts">
        <div class="right-field-posts">
            It's a right-row column.
        </div>
        <div class="right-field-posts">
            Here will be something very important.
        </div>
        <div class="right-field-posts">
            Maybe login form.
        </div>
    </div>

    <div class="row-posts">

        <?php if ($feedItems): ?>
            <?php foreach ($feedItems as $feedItem): ?>
                <?php /* @var $feedItem frontend\models\Post */ ?>

                <!-- feed item -->
                <div class="post">

                    <div class="post-title">
                        <p><?php echo HtmlPurifier::process($feedItem->description); ?></p>
                    </div>
                    <div class="post-type-image">
                        <a href="<?php echo Url::to(['/post/default/view', 'id' => $feedItem->id]); ?>">
                            <img src="<?php echo Yii::$app->storage->getFile($feedItem->filename); ?>" alt="" />  
                        </a>
                    </div>
                    <div class="post-description">
                        <p><?php echo HtmlPurifier::process($feedItem->description); ?></p>
                    </div>
                    <div class="post-bottom">
                        <div class="post-meta">
                            <img src="<?php echo Yii::$app->storage->getFile($feedItem->author_picture); ?>" class="author-image"/>
                            <div class="author-name">
                                <a href="<?php echo Url::to(['/user/profile/view', 'username' => $feedItem->author_name]); ?>">
                                    <?php echo Html::encode($feedItem->author_name); ?>
                                </a>
                            </div>
                        </div>
                        <div class="post-likes">
                            <a href="#!" class="button-like" data-id="<?php echo $feedItem->id; ?>">
                                <?php echo ($currentUser->likesPost($feedItem->id)) ? "Unlike" : "Like"; ?>
                                <span class="glyphicon <?php echo ($currentUser->likesPost($feedItem->id)) ? "glyphicon glyphicon-thumbs-down" : "glyphicon glyphicon-thumbs-up"; ?>"></span>
                            </a>

                            <span class="likes-count"><?php echo $feedItem->countLikes(); ?></span>
                        </div>
                        <div class="post-comments">
                            <a href="#!">0 Comments</a>
                        </div>
                        <div class="post-bottom-right">
                            <div class="post-date">
                                <span><?php echo Yii::$app->formatter->asDatetime($feedItem->created_at, 'php: j M Y h:i'); ?></span>    
                            </div>
                            <div class="post-report">
                                <?php if (!$feedItem->isReported($currentUser)): ?>
                                    <a href="#!" class="btn btn-default button-complain" data-id="<?php echo $feedItem->id; ?>">
                                        Report post <i class="glyphicon glyphicon-refresh icon-preloader" style="display:none"></i>
                                    </a>
                                <?php else: ?>
                                    <p>Post has been reported</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <br><br><br>
                </div>
                <!-- feed item -->

            <?php endforeach; ?>

        <?php else: ?>
            <div class="col-md-12">
                Nobody posted yet!
            </div>
        <?php endif; ?>

    </div>
</div>



<?php
$this->registerJsFile('@web/js/likes.js', [
    'depends' => JqueryAsset::className(),
]);

//$this->registerJsFile('@web/js/123.js', [
//    'depends' => JqueryAsset::className(),
//]);

//$this->registerJsFile('@web/js/complaints.js', [
//    'depends' => JqueryAsset::className(),
//]);
