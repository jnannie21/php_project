<?php

namespace common\filters;

use Yii;
use yii\base\ActionFilter;
use yii\helpers\Url;

/**
 * GoBackFilter sets return URL with [[Yii::$app->user->setReturnUrl()]] 
 * on event [[yii\base\Controller::EVENT_BEFORE_ACTION]]
 * and delete it on event [[yii\base\Controller::EVENT_AFTER_ACTION]]
 * 
 * To use GoBackFilter, declare it in the `behaviors()` method of your controller class.
 * 
 * ```php
 * function behaviors() 
 * {
 *     return [
 *         'goback' => [
 *             'class' => GoBackFilter::class,
 *             'actions' => ['signup', 'login', 'logout', 'request-password-reset'],
 *         ],
 *     ];
 * }
 * ```
 * 
 * @author dmitry polushkin <mdifps@gmail.com>
 */
class GoBackFilter extends ActionFilter {
    
    /**
     *
     * @var array "back actions" 
     */
    public $actions = [];

    /**
     * {@inheritdoc}
     */
    public function beforeAction($action) {

        $referrer = Yii::$app->request->referrer;
        
        if ($referrer && !$this->isThisDomain($referrer)){
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
     * {@inheritdoc}
     */
    public function afterAction($action, $result) {
            
        if (isset($_SESSION[Yii::$app->user->returnUrlParam])) {
            
            $redirectionUrl = Yii::$app->getResponse()->getHeaders()->get('Location');
            
            if ($redirectionUrl === $_SESSION[Yii::$app->user->returnUrlParam]) {
                unset($_SESSION[Yii::$app->user->returnUrlParam]);
            }
        }

        return $result;
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
     * @param string $referrer absolute referrer URL
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
