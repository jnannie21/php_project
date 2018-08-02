<?php
/* @var $this \yii\web\View */
/* @var $currentUser \frontend\models\User */
/* @var $post \frontend\models\Post */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>



<div class="post-title">
    <a href="<?php echo Url::to(['/post/default/view', 'id' => $post->id]); ?>">
    <p><?php echo HtmlPurifier::process($post->description); ?></p>
    </a>
</div>
<div class="post-image">
    <img src="<?php echo $post->getImage(); ?>" alt="" />
</div>
<div class="post-description">
    <p><?php echo HtmlPurifier::process($post->description); ?></p>
</div>
<div class="info-block">
    <div class="info-author">
        <img src="<?php echo Yii::$app->storage->getFile($post->author_picture); ?>" class="author-image"/>
        <div class="author-name">
            <a href="<?php echo Url::to(['/user/profile/view', 'username' => $post->author_name]); ?>">
                <?php echo Html::encode($post->author_name); ?>
            </a>
        </div>
    </div>
    <div class="info-likes">
        <a href="#!" class="button-like" data-entity="post" data-id="<?php echo $post->id; ?>">
            <?php if ($currentUser && $currentUser->likesPost($post->id))
                echo 'Unlike';
            else
                echo 'Like';
            ?>
            <span class="glyphicon <?php if ($currentUser && $currentUser->likesPost($post->id))
                echo "glyphicon-thumbs-down";
            else
                echo "glyphicon-thumbs-up";
            ?>"></span>
        </a>

        <span class="likes-count"><?php echo $post->countLikes(); ?></span>
    </div>
    <div class="info-comments">
        <a href="<?php echo Url::to(['/post/default/view', 'id' => $post->id]); ?>"><?php echo $post->comments_count ?> Comment(s)</a>
    </div>
    <div class="info-block-right">
        <div class="info-date">
            <span><?php echo Yii::$app->formatter->asDatetime($post->created_at, 'php: j M Y h:i'); ?></span>    
        </div>
        <div class="post-report">
            <?php if ($currentUser && !$post->isReported($currentUser)): ?>
<!--                                        <a href="#!" class="btn btn-default button-complain" data-id="<?php echo $post->id; ?>">
                            Report post <i class="glyphicon glyphicon-refresh icon-preloader" style="display:none"></i>
                        </a>-->
<?php else: ?>
                <p>Post has been reported</p>
<?php endif; ?>
        </div>
    </div>
</div>