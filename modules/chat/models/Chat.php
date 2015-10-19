<?php

namespace app\modules\chat\models;

use Yii;
use app\modules\user\models\User;

/**
 * This is the model class for table "chat".
 *
 * @property integer $id
 * @property string $message
 * @property integer $userId
 * @property string $updateDate
 */
class Chat extends \yii\db\ActiveRecord {

    public $userModel;
    public $userField;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'chat';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['message'], 'required'],
            [['userId'], 'integer'],
            [['updateDate', 'message'], 'safe']
        ];
    }

    public function getUser() {
        if (isset($this->userModel))
            return $this->hasOne($this->userModel, ['id' => 'userId']);
        else
            return $this->hasOne(Yii::$app->getUser()->identityClass, ['id' => 'userId']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'message' => 'Message',
            'userId' => 'User',
            'updateDate' => 'Update Date',
        ];
    }

    public function beforeSave($insert) {
        $this->userId = Yii::$app->user->id;
        return parent::beforeSave($insert);
    }

    public static function records() {
        return static::find()->orderBy('id desc')->limit(10)->all();
    }

    public static function allUsers() {
        return static::find()->orderBy('id desc')->all();
    }

    public function users() {
        $output = '';
        $allUsers = User::getAllUsers();
        if ($allUsers) {
            foreach ($allUsers as $userItem) {
                $output['userList'] .= '<li>
                    <a href="#">' . $userItem->username . '</a>
                </li>';
            }
        }
        return $output;
    }

    public function conversation() {
        $userField = $this->userField;
        $output = ['userList' => '', 'chat' => ''];
        $models = Chat::records();
        $allUsers = User::getAllUsers();
        if ($allUsers) {
            foreach ($allUsers as $userItem) {
                $output['userList'] .= '<li>
                    <a href="#">' . $userItem->username . '</a>
                </li>';
            }
        }
        if ($models)
            foreach ($models as $model) {
                if (isset($model->user->$userField)) {
                    $avatar = $model->user->$userField;
                } else{
                    //$avatar = Yii::$app->assetManager->getPublishedUrl("@modules/chat/assets/img/avatar.png");
                    $avatar = Yii::$app->assetManager->getPublishedUrl("/assets/img/avatar.png");
                }


                    
                $output['chat'] .= '<div class="item">
                <img class="online" alt="user image" src="' . $avatar . '">
                <p class="message">
                    <a class="name" href="#">
                        <small class="text-muted pull-right" style="color:green"><i class="fa fa-clock-o"></i> ' . \kartik\helpers\Enum::timeElapsed($model->updateDate) . '</small>
                        ' . $model->user->username . '
                    </a>
                   ' . $model->message . '
                </p>
            </div>';
            }

        return $output;
    }
}
