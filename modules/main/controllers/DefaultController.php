<?php

namespace app\modules\main\controllers;
 
use yii\web\Controller;
use Yii;
 
class DefaultController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
 
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->render('index');
        }
        else
        {
            $this->redirect('chat', false, 302);
        }
    }
}