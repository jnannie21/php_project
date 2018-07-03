<?php

namespace common\filters;

use Yii;
use yii\base\ActionFilter;
use yii\helpers\Url;

class GoBackFilter extends ActionFilter {

    public $actions = [];

    public function beforeAction($action) {

        $referrer = Yii::$app->request->referrer;
        
        if (!$this->isThisDomain($referrer)){
            $referrer = null;
        }
        
        if ($referrer && $this->isBackAction($referrer)){
            return true;
        }
       
        if (in_array($action->id, $this->actions)) {
            Yii::$app->user->setReturnUrl($referrer);
        }

        return true;
    }

    /**
     * @param string $referrer referer URL
     * @return boolean is request came from this domain
     */
    public function isThisDomain($referrer) {
        $referrerDomain = parse_url($referrer, PHP_URL_HOST);
        
        $serverName = Yii::$app->request->serverName;
        
        if ($referrerDomain !== $serverName){
            return false;
        }
        
        return true;
    }
    
    /**
     * @param string $referrer referrer URL
     * @return boolean is referer one of this "back actions"
     */
    protected function isBackAction($referrer) {
        $ControllerID = $this->owner->getUniqueId();
        
        foreach ($this->actions as $act) {
            $route = $ControllerID . '/' . $act;
            $url = Url::to($route, true);
            if ($referrer === $url) {
                return true;
            }
        }
        return false;
    }
    
}
