<?php

namespace app\modules\chat\controllers;

use Yii;
use yii\web\Controller;
use app\modules\chat\models\Chat;
use app\modules\user\models\User;
 
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
        $data = $model->users();
        return $this->render('index', [
                    'data' => $data,
                    'url' => $module->url,
                    'userModel' => $module->userModel,
                    'userField' => $module->userField,
                    'loading' => $module->loadingImage
        ]);
    }

    public function actionDeletemessage()
    {
        if (!empty($_POST))
        {
            if (isset($_POST['id']))
                $messageId = $_POST['id'];
            $model = Chat::findOne($messageId);
            $model->isDelete = 1;
            if ($model->save())
            {
                echo json_encode("doneDelete");
            }
        }
    }

    public function actionReadmessage()
    {
        if (!empty($_POST))
        {
            if (isset($_POST['id']))
                $messageId = $_POST['id'];
            $model = Chat::findOne($messageId);
            $model->isRead = 1;
            if ($model->save())
            {
                echo json_encode("doneRead");
            }
        }
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

            $model = new Chat();
            $model->userModel = $userModel;
            $model->userId = Yii::$app->user->id;
            $model->user2Model = User::findByUsername($user2);

            echo json_encode($model->conversation());
        }
    }

    public function actionSendchat()
    {
        if (!empty($_POST))
        {
            if (isset($_POST['message']))
                $message = $_POST['message'];
            if (isset($_POST['model']))
                $userModel = $_POST['model'];
            else
                $userModel = Yii::$app->getUser()->identityClass;
            if (isset($_POST['userfield']))
                $userField = $_POST['userfield'];
            if (isset($_POST['user2Name']))
                $user2Name = $_POST['user2Name'];

            $model = new Chat();
            $model->userModel = $userModel;
            $model->userId = Yii::$app->user->id;
            $model->user2Model = User::findByUsername($user2Name);

            if ($message) {
                $model->message = $message;
                $model->user2Id = $model->user2Model->id;
                $model->isRead = 0;
                $model->isDelete = 0;

                if ($model->save()) {
                    //echo json_encode($model->getNewItem());
                    echo json_encode($model->conversation());
                } else {
                    print_r($model->getErrors());
                    exit(0);
                }
            } else {
                echo json_encode($model->conversation());
            }
        }
    }
}