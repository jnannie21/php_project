<?php
/* @var $this yii\web\View */
/* @var $model frontend\modules\post\models\forms\PostForm */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<div class="post-form">

    <h3>Create post</h3>

    <?php
    $form = ActiveForm::begin();
    ?>
    <label for="postform-picture">
        <?= '<div class="load-picture-btn btn btn-sm btn-default">Add picture</div>' ?>
    </label>
    <output class="thumb-list" id="thumb-list">
    </output>
    <div class="picture-input">
        <?php echo $form->field($model, 'picture[]', ['template' => "{input}"])->label(false)->fileInput(['id' => 'postform-picture', 'multiple' => true]); ?>
    </div>
    <?php echo $form->field($model, 'description')->label(false)->textarea(['class' => 'form-control postform-text-content']); ?>

    <?php echo Html::submitButton('Create'); ?>

    <br><br>
<!--
    <div contenteditable="true" style="width: 100%; height: 100px" placeholder="Leave a comment" class="form-control">
                        <blockquote>Текст</blockquote>
        <span></span>

    </div>-->

    <?php ActiveForm::end(); ?>

</div>

<?php
$this->registerJsFile('@web/js/postformThumbnails.js');
