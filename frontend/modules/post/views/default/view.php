<?php
/* @var $this \yii\web\View */
/* @var $currentUser \frontend\models\User */
/* @var $post \frontend\models\Post */
/* @var $model \frontend\modules\post\models\forms\CommentForm */
/* @var $comments \frontend\models\Comment[] */

use yii\web\JqueryAsset;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\ActiveForm;

$this->title = 'Post';
?>

<div class="page-posts">

    <!-- post -->

    <div class="post">

        <div class="post-title">
            <p><?php echo HtmlPurifier::process($post->description); ?></p>
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
                <a href="#!" class="button-like" data-id="<?php echo $post->id; ?>">
                    <?php echo ($currentUser->likesPost($post->id)) ? "Unlike" : "Like"; ?>
                    <span class="glyphicon <?php echo ($currentUser->likesPost($post->id)) ? "glyphicon glyphicon-thumbs-down" : "glyphicon glyphicon-thumbs-up"; ?>"></span>
                </a>

                <span class="likes-count"><?php echo $post->countLikes(); ?></span>
            </div>
            <div class="post-comments">
                <a href="#!">0 Comments</a>
            </div>
            <div class="info-block-right">
                <div class="info-date">
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
        <br>
    </div>
    <!-- post -->


    <!-- comment form -->
    <div class="comment-form">

        <?php $form = ActiveForm::begin([
            'options' => ['action' => '/post/default/add-comment', 'id' => 'comment-form', 'data-post-id' => $post->id, 'data-parent-id' => ''
            ]]);
        ?>

        <div contenteditable="true" class="form-control comment-form__text-content" id="comment-form__text-content" data-placeholder="Add a comment"></div>
        <div class="comment-form__send-btn btn btn-sm btn-default">Send</div>

        <label for="commentform-picture">
            <div class="load-picture-btn btn btn-sm btn-default">Add picture</div>
        </label>
        <?php echo $form->field($model, 'picture[]', ['template' => "{input}"])->label(false)->fileInput(['class' => 'load-picture-input', 'multiple' => 'multiple']); ?>

        <?php ActiveForm::end(); ?>

    </div>
    <!-- comment form -->

    
    <!-- comments -->
    <div class="comments-block" id="comments-block">
        <?php foreach ($comments as $comment): ?>

            <?= $this->render('comment',[
                'comment' => $comment,
                'currentUser' => $currentUser,
            ]) ?>

        <?php endforeach; ?>
    </div>
    <!-- comments -->

</div>



<?php
$this->registerJsFile('@web/js/likes.js', [
    'depends' => JqueryAsset::className(),
]);
$this->registerJsFile('@web/js/addComment.js', [
    'depends' => JqueryAsset::className(),
]);
//$this->registerJsFile('@web/js/complaints.js', [
//    'depends' => JqueryAsset::className(),
//]);