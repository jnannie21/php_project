<?php
/* @var $this yii\web\View */
/* @var $model frontend\modules\post\models\forms\PostForm */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<div class="post-create-form">
    
    <h3>Create post</h3>

    <?php $form = ActiveForm::begin(); ?>

        <label>
            <?= '<div class="load-picture-btn btn btn-default">Add picture</div>' ?>
            <?php echo $form->field($model, 'picture[]')->label(false)->fileInput(['class' => 'load-picture-input', 'multiple' => 'multiple']); ?>
        </label>
    
        <output id="thumb-list">
        </output>
    
        <?php echo $form->field($model, 'description')->textarea(['class' => 'form-control text-content-input']); ?>
    
        <?php echo Html::submitButton('Create'); ?>
    
    <?php ActiveForm::end(); ?>
    
</div>

<?php
$this->registerJsFile('@web/js/postformThumbnails.js');