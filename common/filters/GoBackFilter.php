<?php

namespace common\filters;

use Yii;
use yii\base\ActionFilter;
use yii\web\User;
use yii\helpers\Url;

class GoBackFilter extends ActionFilter {

    public $actions = [];

    public function beforeAction($action) {

//        $currentUrl = Url::current([], true);
        $referrer = Yii::$app->request->referrer;

        $ControllerID = $this->owner->getUniqueId();
        
        foreach ($this->actions as $act) {
            $route = $ControllerID . '/' . $act;
            $url = Url::to($route, true);
            if ($referrer === $url) {
                return true;
            }
        }

        $returnUrlParam = Yii::$app->user->returnUrlParam;

        if (in_array($action->id, $this->actions)) {
            Yii::$app->user->setReturnUrl(Yii::$app->request->referrer);
        } elseif (isset($_SESSION[$returnUrlParam])) {
            unset($_SESSION[$returnUrlParam]);
        }

        return true;
    }

}
