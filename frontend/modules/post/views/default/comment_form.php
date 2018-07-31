<?php
/* @var $this \yii\web\View */
/* @var $post \frontend\models\Post */
/* @var $model \frontend\modules\post\models\forms\CommentForm */

use yii\widgets\ActiveForm;
?>

<?php
$form = ActiveForm::begin([
            'options' => ['action' => '/post/default/add-comment', 'id' => 'comment-form', 'data-post-id' => $post->id, 'data-parent-id' => ''
        ]]);
?>

<div contenteditable="true" class="form-control comment-form__text-content" data-placeholder="Add a comment"></div>
<div class="comment-form__send-btn btn btn-sm btn-default">Send</div>

<label for="commentform-picture">
    <div class="load-picture-btn btn btn-sm btn-default">Add picture</div>
</label>
<?php echo $form->field($model, 'picture[]', ['template' => '{input}'])->label(false)->fileInput(['class' => 'load-picture-input', 'multiple' => true]); ?>
<div class="help-block"></div>
<?php ActiveForm::end(); ?>