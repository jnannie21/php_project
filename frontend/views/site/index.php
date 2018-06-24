<?php
/* @var $this yii\web\View */
/* @var array $users frontend\models\User */

use yii\helpers\Url;

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Congratulations!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
    </div>

    <div class="body-content">

        <?php foreach ($users as $user): ?>
            <a href = "<?php echo Url::to(['/user/profile/view', 'username' => $user->username]); ?>">
                <?php echo $user->username . " => "; ?>
                <?php echo $user->email . " => "; ?>
                <?php echo $user->status; ?>
            </a>
            <hr>
        <?php endforeach; ?>

    </div>
</div>
