<?php
/* @var $this yii\web\View */
/* @var $user frontend\models\User */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

?>

<h3><?php echo Html::encode($user->username); ?></h3>

<p><?php echo HtmlPurifier::process($user->about); ?></p>
<hr>

<a href="<?php echo Url::to(['/user/profile/subscribe', 'id' => $user->getId()]); ?>" class="btn btn-info">Subscribe</a>
<a href="<?php echo Url::to(['/user/profile/unsubscribe', 'id' => $user->getId()]); ?>" class="btn btn-info">Unsubscribe</a>

<hr>

<?php
echo 'getSubscriptions:';
echo '<br/>';
var_dump($user->getSubscriptions());

echo '<hr>';

echo 'getFollowers:';
echo '<br/>';
var_dump($user->getFollowers());
