<?php

namespace app\modules\chat;

use Yii;
use yii\web\AssetBundle;

class ChatAsset extends AssetBundle {

    public $sourcePath = '@app/modules/chat/assets';

    public $js = [
        'js/chat.js',
    ];
    public $css = [
        'css/simple-sidebar.css',
        'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}