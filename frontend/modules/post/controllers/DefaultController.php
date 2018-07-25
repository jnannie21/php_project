<?php

namespace frontend\modules\post\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;
use frontend\models\Post;
use frontend\modules\post\models\forms\PostForm;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `post` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the create view for the module
     * @return string
     */
    public function actionCreate()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }
        
        $model = new PostForm(Yii::$app->user->identity);
        
        if ($model->load(Yii::$app->request->post())) {
            
            $model->picture = UploadedFile::getInstance($model, 'picture[0]');
        
            if ($model->save()) {
                
                Yii::$app->session->setFlash('success', 'Post created!');
                return $this->goHome();
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    
    /**
     * Renders the create view for the module
     * @return string
     */
    public function actionView($id)
    {        
        /* @var $currentUser \frontend\models\User */
        $currentUser = Yii::$app->user->identity;    
        
        return $this->render('view', [
            'post' => $this->findPost($id),
            'currentUser' => $currentUser,
        ]);
    }
    
    public function actionLike()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }
        
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        $id = Yii::$app->request->post('id');
        $post = $this->findPost($id);
        
        /* @var $currentUser \frontend\models\User */
        $currentUser = Yii::$app->user->identity;        
        
        $post->like($currentUser);

        return [
            'success' => true,
            'likesCount' => $post->countLikes(),
        ];     
    }

    public function actionUnlike()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->post('id');

        /* @var $currentUser \frontend\models\User */
        $currentUser = Yii::$app->user->identity;
        $post = $this->findPost($id);

        $post->unLike($currentUser);

        return [
            'success' => true,
            'likesCount' => $post->countLikes(),
        ];
    }

    /**
     * @param integer $id
     * @return \frontend\models\Post
     * @throws NotFoundHttpException
     */
    private function findPost($id)
    {
        if ($post = Post::findOne($id)) {
            return $post;
        }
        throw new NotFoundHttpException();
    }

    public function actionComplain()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->post('id');

        /* @var $currentUser \frontend\models\User */
        $currentUser = Yii::$app->user->identity;
        $post = $this->findPost($id);

        if ($post->complain($currentUser)) {
            return [
                'success' => true,
                'text' => 'Post reported'
            ];
        }
        return [
            'success' => false,
            'text' => 'Error',
        ];
    }
}
