<?php
/* @var $this \yii\web\View */
/* @var $currentUser \frontend\models\User */
/* @var $post \frontend\models\Post */
/* @var $model \frontend\modules\post\models\forms\CommentForm */
/* @var $comments \frontend\models\Comment[] */

use yii\web\JqueryAsset;

$this->title = 'Post';
?>

<div class="right-row">
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

<div class="post-with-comments">
    
    <!-- post -->
    <div class="post">
        
            <?= $this->render('post',[
                'post' => $post,
                'currentUser' => $currentUser,
            ]) ?>
     </div>
    
    <!-- post -->


    <!-- comment form -->
    <div class="comment-form">

            <?= $this->render('comment_form',[
                'post' => $post,
                'model' => $model,
            ]) ?>

    </div>
    <!-- comment form -->

    
    <!-- comments -->
    <div class="comments-row">
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
$this->registerJsFile('@web/js/commentFormThumbnails.js', [
    'depends' => JqueryAsset::className(),
]);
$this->registerJsFile('@web/js/addComment.js', [
    'depends' => JqueryAsset::className(),
]);
//$this->registerJsFile('@web/js/complaints.js', [
//    'depends' => JqueryAsset::className(),
//]);