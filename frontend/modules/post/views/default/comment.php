<?php
/* @var $this \yii\web\View */
/* @var $currentUser \frontend\models\User */
/* @var $comment \frontend\models\Comment */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>

<div class="comment">
    <div class="info-block">
        <div class="info-author">
            <img src="<?php echo Yii::$app->storage->getFile($comment->author_picture); ?>" class="author-image"/>
            <div class="author-name">
                <a href="<?php echo Url::to(['/user/profile/view', 'username' => $comment->author_name]); ?>">
                    <?php echo Html::encode($comment->author_name); ?>
                </a>
            </div>
        </div>
        <div class="info-likes">
            <a href="#!" class="button-like" data-entity="comment" data-id="<?php echo $comment->id; ?>">
                <?php
                if ($currentUser && $currentUser->likesComment($comment->id))
                    echo "Unlike";
                else
                    echo "Like";
                ?>
                <span class="glyphicon <?php
                if ($currentUser && $currentUser->likesComment($comment->id))
                    echo "glyphicon-thumbs-down";
                else
                    echo "glyphicon-thumbs-up";
                ?>"></span>
            </a>

            <span class="likes-count"><?php echo $comment->countLikes(); ?></span>
        </div>


        <div class="comment-reply">
            <a href="#!" class="btn-reply" data-id="<?php echo $comment->id; ?>">Reply
            </a>
        </div>

        <div class="info-block-right">
            <div class="info-date">
                <span><?php echo Yii::$app->formatter->asDatetime($comment->created_at, 'php: j M Y h:i'); ?></span>    
            </div>
        </div>
    </div>

    <?php if ($comment->filename): ?>
    <div class="comment-image">
        <img src="<?php echo $comment->getImage(); ?>" alt="" />
    </div>
    <?php endif; ?>

    <div class="comment-content">
        <?php echo HtmlPurifier::process($comment->content); ?>
    </div>
</div>