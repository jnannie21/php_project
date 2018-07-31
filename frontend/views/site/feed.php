<?php
/* @var $this \yii\web\View */
/* @var $currentUser \frontend\models\User */
/* @var $feedItems \frontend\models\Post[] */

use yii\web\JqueryAsset;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

$this->title = 'Newsfeed';
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

    <div class="row-posts">

        <?php if ($feedItems): ?>
            <?php foreach ($feedItems as $feedItem): ?>
                <?php /* @var $post \frontend\models\Post */ ?>

                <!-- feed item -->
                <div class="post">

                    <?= $this->render('@post/views/default/post', [     //render post view from post module
                        'post' => $feedItem,
                        'currentUser' => $currentUser,
                    ]) ?>

                </div>
                <!-- feed item -->

            <?php endforeach; ?>

<?php else: ?>
            <div class="col-md-12">
                Nobody posted yet!
            </div>
<?php endif; ?>

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
