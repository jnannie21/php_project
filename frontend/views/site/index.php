<?php
/* @var $this yii\web\View */
/* @var array $users frontend\models\User */

use yii\helpers\Url;

$this->title = 'My Yii Application';
?>
<div class="site-index">
    
    <div class="text-center">
        <h1>Congratulations!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>

        <p>
            <a class="btn btn-lg btn-default" href="
            <?php
            if (!Yii::$app->user->isGuest) {
                echo Url::to(['/user/profile/view', 'username' => Yii::$app->user->identity->username]);
            } else {
                echo Url::home();
            }
            ?>">
                Profile
            </a>
        </p>
    </div>

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