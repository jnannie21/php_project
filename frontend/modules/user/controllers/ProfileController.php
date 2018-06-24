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
        ]);    }

}
