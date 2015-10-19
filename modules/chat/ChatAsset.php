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
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}