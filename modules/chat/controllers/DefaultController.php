<?php

namespace app\modules\chat\controllers;

use Yii;
use yii\web\Controller;
use app\modules\chat\models\Chat;
 
class DefaultController extends Controller
{
    // public function actions()
    // {
    //     return [
    //         'error' => [
    //             'class' => 'yii\web\ErrorAction',
    //         ],
    //     ];
    // }
 
    public function actionIndex()
    {
        $module = \Yii::$app->controller->module;
        $model = new Chat();
        $model->userModel = $module->userModel;
        $model->userField = $module->userField;
        $data = $model->conversation();
        return $this->render('index', [
                    'data' => $data,
                    'url' => $module->url,
                    'userModel' => $module->userModel,
                    'userField' => $module->userField,
                    'loading' => $module->loadingImage
        ]);
    }

    public function actionGetnewchat()
    {
        if (!empty($_POST))
        {
            if (isset($_POST['user2']))
                $user2 = $_POST['user2'];
            if (isset($_POST['model']))
                $userModel = $_POST['model'];
            else
                $userModel = Yii::$app->getUser()->identityClass;

            $model = new Chat;
            $model->userModel = $userModel;

            echo $model->conversation();
        }
    }

    public function actionSendchat()
    {
        if (!empty($_POST))
        {
            if (isset($_POST['message']))
                $message = $_POST['message'];
            if (isset($_POST['userfield']))
                $userField = $_POST['userfield'];
            if (isset($_POST['model']))
                $userModel = $_POST['model'];
            else
                $userModel = Yii::$app->getUser()->identityClass;

            $model = new Chat;
            $model->userModel = $userModel;
            if ($userField)
                $model->userField = $userField;

            if ($message) {
                $model->message = $message;
                $model->userId = Yii::$app->user->id;

                if ($model->save()) {
                    echo $model->conversation();
                } else {
                    print_r($model->getErrors());
                    exit(0);
                }
            } else {
                echo $model->conversation();
            }
        }
    }

    // public function actionSendchat()
    // {
    //     if (!empty($_POST))
    //     {
    //         if (isset($_POST['message']))
    //             $message = $_POST['message'];
    //         if (isset($_POST['userfield']))
    //             $userField = $_POST['userfield'];
    //         if (isset($_POST['model']))
    //             $userModel = $_POST['model'];
    //         else
    //             $userModel = Yii::$app->getUser()->identityClass;

    //         $model = new Chat;
    //         $model->userModel = $userModel;
    //         if ($userField)
    //             $model->userField = $userField;

    //         if ($message) {
    //             $model->message = $message;
    //             $model->userId = Yii::$app->user->id;

    //             if ($model->save()) {
    //                 echo $model->data();
    //             } else {
    //                 print_r($model->getErrors());
    //                 exit(0);
    //             }
    //         } else {
    //             echo $model->data();
    //         }
    //     }
    // }
}