<?php

namespace frontend\modules\user\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\User;

class ProfileController extends Controller {

    public function actionView($username) {
        $user = User::findByUsername($username);
        return $this->render('view', [
                    'user' => $user,
        ]);
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
