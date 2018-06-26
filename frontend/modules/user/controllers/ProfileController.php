<?php

namespace frontend\modules\user\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\User;
use yii\web\NotFoundHttpException;

class ProfileController extends Controller {

    /**
     * User profile
     * 
     * @param string $username
     */
    public function actionView($username) {
        $user = User::findByUsername($username);
        return $this->render('view', [
                    'user' => $user,
        ]);
    }

    /**
     * Subscribe current user to user with given ID
     * 
     * @param string|int $id given ID
     * @return Response
     */
    public function actionSubscribe($id) {
        
        $user = $this->findUserById($id);

        /* @var $currentUser User */
        $currentUser = Yii::$app->user->identity;

        $currentUser->followUser($user);

        return $this->redirect(['/user/profile/view', 'username' => $user->username]);
    }

    /**
     * Unsubscribe current user from user with given ID
     * 
     * @param string|int $id given ID
     * @return Response
     */
    public function actionUnsubscribe($id) {

        $user = $this->findUserById($id);

        /* @var $currentUser User */
        $currentUser = Yii::$app->user->identity;

        $currentUser->unfollowUser($user);

        return $this->redirect(['/user/profile/view', 'username' => $user->username]);
    }

    /**
     * Finds user by ID
     * 
     * @param string|int $id given ID
     * @return User
     * @throws NotFoundHttpException
     */
    public function findUserById($id) {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }

        if ($user = User::findIdentity($id)) {
            return $user;
        }
        throw new NotFoundHttpException();
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
