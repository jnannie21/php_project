<?php

namespace frontend\modules\user\controllers;

use Yii;
use yii\web\Controller;
use common\models\User;

class ProfileController extends Controller {

    public function actionView($id) {
        $user = User::findIdentity($id);
        return $this->render('view', [
                    'user' => $user,
        ]);    }

}
