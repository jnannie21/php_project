<?php

namespace frontend\modules\user\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\User;
use yii\web\NotFoundHttpException;
use frontend\modules\user\models\forms\PictureForm;
use yii\web\UploadedFile;
use yii\web\Response;
use yii\helpers\Url;

class ProfileController extends Controller {
    
    /**
     * User profile
     * 
     * @param string|int $username Username or user ID
     */
    public function actionView($username) {

        if (!$user = User::findByUsername($username)){
            if (!$user = User::findIdentity($username)){
                throw new NotFoundHttpException();
            }
        }
                
        $modelPicture = new PictureForm();

        return $this->render('view', [
                    'user' => $user,
                    'currentUser' => Yii::$app->user->identity,
                    'modelPicture' => $modelPicture,
        ]);
    }

    /**
     * Subscribe current user to user with given ID
     * 
     * @param string|int $id given ID
     * @return Response
     */
    public function actionSubscribe($id) {

        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }

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

        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }

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

        if ($user = User::findIdentity($id)) {
            return $user;
        }
        throw new NotFoundHttpException();
    }

    /**
     * Profile image upload via ajax request
     */
    public function actionUploadPicture() {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = new PictureForm();
        $model->picture = UploadedFile::getInstance($model, 'picture');

        if ($model->validate()) {
            $user = Yii::$app->user->identity;
            $user->picture = Yii::$app->storage->saveUploadedFile($model->picture);

            if ($user->save(false, ['picture'])) {
                return [
                    'success' => true,
                    'pictureUri' => Yii::$app->storage->getFile($user->picture),
                ];
            }
        }
        
        return ['success' => false, 'errors' => $model->getErrors()];
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
