<?php

namespace frontend\modules\user\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\User;
use yii\web\NotFoundHttpException;

class ProfileController extends Controller {

    public function actionView($username) {
        $user = User::findByUsername($username);
        return $this->render('view', [
                    'user' => $user,
        ]);
    }

    public function actionSubscribe($id) {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }

        /* @var $currentUser User */
        $currentUser = Yii::$app->user->identity;
        if (!$user = User::findIdentity($id)) {
            throw new NotFoundHttpException();
        }

        $currentUser->followUser($user);

        return $this->redirect(['/user/profile/view', 'username' => $user->username]);
    }

    public function actionUnsubscribe() {
        
    }

//    public function actionGenerate() {
//        $faker = \Faker\Factory::create();
//
//        for ($i = 0; $i < 1000; $i++) {
//            $user = new User([
//                'username' => User::findByUsername($username = $faker->regexify('[A-Z]?[a-z_]{5,10}[0-9]{1,5}')) ? null : $username,
//                'email' => User::findByEmail($email = $faker->email) ? null : $email,
//                'about' => $faker->text(200),
//                'auth_key' => Yii::$app->security->generateRandomString(),
//                'password_hash' => Yii::$app->security->generateRandomString(),
//                'created_at' => $time = time(),
//                'updated_at' => $time,
//            ]);
//
//            $user->email and $user->username and $user->save();
//        }
//    }
}
