<?php

namespace app\modules\chat;
use app\modules\chat\models\Chat;
use Yii;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\chat\controllers';
    public $css = [
    ];
    public $js = [ // Configured conditionally (source/minified) during init()
        'js/chat.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public $models;
    public $url;
    public $userModel;
    public $userField;
    public $model;
    public $loadingImage;


    public function init()
    {
		$this->model = new Chat();
        if ($this->userModel === NULL) {
            $this->userModel = Yii::$app->getUser()->identityClass;
        }

        $this->model->userModel = $this->userModel;

        if ($this->userField === NULL) {
            $this->userField = 'avatarImage';
        }

        $this->model->userField = $this->userField;
        Yii::$app->assetManager->publish(Yii::$app->basePath."/modules/chat/assets/img/loadingAnimation.gif");
        $this->loadingImage = Yii::$app->assetManager->getPublishedUrl(Yii::$app->basePath."/modules/chat/assets/img/loadingAnimation.gif");    	
        parent::init();

        // custom initialization code goes here
    }
}
