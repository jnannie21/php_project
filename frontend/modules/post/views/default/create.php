<?php
/* @var $this yii\web\View */
/* @var $model frontend\modules\post\models\forms\PostForm */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<div class="post-create-form">
    
    <h3>Create post</h3>

    <?php $form = ActiveForm::begin(); ?>
    
        <?= '<div class="load-picture-btn btn btn-default">Load picture</div>' ?>
    
        <?php echo $form->field($model, 'picture')->label(false)->fileInput(['class' => 'load-picture-input']); ?>
    
        <?php echo $form->field($model, 'description')->textarea(['class' => 'form-control text-content-input']); ?>
    
        <?php echo Html::submitButton('Create'); ?>
    
    <?php ActiveForm::end(); ?>
    
</div>
