<?php
/* @var $this yii\web\View */
/* @var $post frontend\models\Post */

use yii\helpers\Html;
use yii\web\JqueryAsset;

?>
<div class="post-default-index">

    <div class="row">

        <div class="col-md-12">
            <?php if ($post->user): ?>
                <?php echo $post->user->username; ?>
            <?php endif; ?>
        </div>
        
        <div class="col-md-12">
            <img src="<?php echo $post->getImage(); ?>" height="400"/>
        </div>

        <div class="col-md-12">
            <?php echo Html::encode($post->description); ?>
        </div>
        
    </div>

    <hr>
    
    <div class="col-md-12">
        Likes: <span class="likes-count"><?php echo $post->countLikes(); ?></span>

        <a href="#" class="btn btn-primary button-like" data-id="<?php echo $post->id; ?>">
            <?php echo ($currentUser && $post->isLikedBy($currentUser)) ? "Unlike" : "Like"; ?>&nbsp;&nbsp;
            <span class="glyphicon <?php echo ($currentUser && $post->isLikedBy($currentUser)) ? "glyphicon-thumbs-down" : "glyphicon-thumbs-up"; ?>">
            </span>
        </a>

    </div>

</div>


<?php $this->registerJsFile('@web/js/likes.js', [
    'depends' => JqueryAsset::className(),
]);
