<?php
/* @var $this yii\web\View */
/* @var array $users frontend\models\User */

use yii\helpers\Url;

$this->title = 'My Yii Application';
?>
<br>
<br>
<br>
<br>
<br>
<div class="site-index">
    <div class="body-content">

        <?php foreach ($users as $user): ?>
            <a href = "<?php echo Url::to(['/user/profile/view', 'username' => $user->username]); ?>">
                <?php echo $user->id . " => "; ?>
                <?php echo $user->username . " => "; ?>
                <?php echo $user->email . " => "; ?>
                <?php echo $user->status; ?>
            </a>
            <hr>
        <?php endforeach; ?>

    </div>
</div>