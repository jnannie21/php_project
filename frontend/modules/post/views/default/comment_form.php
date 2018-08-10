<?php
/* @var $this \yii\web\View */
/* @var $post \frontend\models\Post */
/* @var $model \frontend\modules\post\models\forms\CommentForm */

use yii\widgets\ActiveForm;
?>

<?php
$form = ActiveForm::begin([
            'options' => [
                'action' => '/post/default/add-comment',
                'id' => 'comment-form',
                'data-post-id' => $post->id,
                'data-parent-id' => '',
                'data-maxfilesize' => $model->getMaxFileSize(),
                'class' => 'active',
        ]]);
?>

<div contenteditable="true" class="form-control comment-form__content" id="comment-form__content" data-placeholder="Add a comment"></div>
<div class="comment-form__send-btn btn btn-sm btn-default display-none">Send</div>

<label for="commentform-picture">
    <div class="load-picture-btn btn btn-sm btn-default display-none">Add picture</div>
</label>
<div class="picture-input">
    <?php echo $form->field($model, 'pictures[]', ['template' => '{input}'])->label(false)->fileInput(['id' => 'commentform-picture', 'multiple' => true]); ?>
</div>
<div class="help-block"></div>
<?php ActiveForm::end(); ?>