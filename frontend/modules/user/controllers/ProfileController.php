<?php

namespace frontend\modules\user\controllers;

use Yii;
use yii\web\Controller;


class ProfileController extends Controller {

    public function actionView($id) {
        return $this->render('view');
    }

}
