<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\User;
use frontend\models\Post;

/**
 * Site controller
 */
class SiteController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage
     *
     * @return string
     */
    public function actionIndex() {

        $currentUser = Yii::$app->user->identity;

        $limit = Yii::$app->params['feedPostLimit'];
        $feedItems = $this->getFeed($limit);

        return $this->render('feed', [
                    'feedItems' => $feedItems,
                    'currentUser' => $currentUser,
        ]);
    }
    
    /**
     * Displays feed
     *
     * @return string
     */
    public function actionFeed() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }

        $currentUser = Yii::$app->user->identity;

        $limit = Yii::$app->params['feedPostLimit'];
        $feedItems = $currentUser->getFeed($limit);

        return $this->render('feed', [
                    'feedItems' => $feedItems,
                    'currentUser' => $currentUser,
        ]);
    }

    /**
     * Displays list of users
     * 
     * @return string
     */
    public function actionUsers() {
        $users = User::find()->all();
        return $this->render('users', [
                    'users' => $users,
        ]);        
    }
    
    /**
     * Get posts for feed
     * @param integer $limit
     * @return array
     */
    public function getFeed(int $limit)
    {
        $order = ['created_at' => SORT_DESC];

        return Post::find()->orderBy($order)->limit($limit)->all();
    }
    
    public function actionTest() {

//        $comment = new Comment();
//
//        var_dump($comment->attributes);
//
//        die;
        
//        $sql = 'select password_reset_token from user where id = 33694';
//        $result = Yii::$app->db->createCommand($sql)->queryAll();
//        var_dump($result[0]['password_reset_token'] === null);
//        die;
    }
}
