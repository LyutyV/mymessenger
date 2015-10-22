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
    public $user2Model;
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
            [['message', 'userId', 'user2Id'], 'required'],
            [['userId'], 'integer'],
            [['user2Id'], 'integer'],
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
            'user`2Id' => 'User2',
            'updateDate' => 'Update Date',
        ];
    }

    public static function records($userId, $user2Id) {
        return static::findBySql("SELECT * FROM `chat` WHERE userId = ".$userId." AND user2Id = ".$user2Id."
                                    OR userId = ".$user2Id." AND user2Id = ".$userId." ORDER BY id DESC")->all();
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
        $output = ['user2' => '', 'chat' => ''];
        $models = Chat::records($this->userId, $this->user2Model->id);
        $output['user2'] = $this->user2Model->username;
        
        if ($models)
            foreach ($models as $model) {
                $isRead = $model->isRead ? 'fa-check-square-o':'fa-square-o';
                $isDeleted = $isDisabled = '';
                if (!$model->isDelete)
                {
                    $isDisabledDeleteButton = ' disabled';
                }
                else
                {
                    $isDeleted = '<span class="text-danger">Deleted</span>';
                    $isDisabledDeleteButton = '';
                }
                if (!$model->isRead)
                {
                    $message = "<button type='button' class='btn btn-success' id='refreshButton' data-id='".$model->id."'><i class='fa fa-refresh fa-spin'></i> New message...</button>";
                    $isDisabledEditButton = ' disabled';
                }
                else
                {
                    $message = '<input class="col-md-12" type="text" disabled="disabled" value="' . $model->message . '">';
                    $isDisabledEditButton = '';
                    $isDisabledDeleteButton = '';
                }
//<input class="col-md-12" type="text" disabled="disabled" value="' . $message . '">
                $output['chat'] .= '<div class="item">
                <p class="message">
                    <a class="name" href="#">
                        <small class="text-muted pull-right" style="color:green"><i class="fa fa-clock-o"></i> ' . \kartik\helpers\Enum::timeElapsed($model->updateDate) . '</small>
                        ' . $model->user->username . '
                    </br>
                    </a>
                    ' . $message . '
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary'.$isDisabledEditButton.'" id="editButton" data-id="'.$model->id.'"><i class="fa fa-pencil fa-fw"></i></button>
                        <button type="button" class="btn btn-danger'.$isDisabledDeleteButton.'" id="deleteButton" data-id="'.$model->id.'"><i class="fa fa-trash-o fa-lg"></i></button>
                    </div>
                    <span class="fa-stack fa-lg' . $model->id . '">
                        <i class="fa fa-square-o fa-stack-2x"></i>
                        <i class="fa '. $isRead .' fa-stack-1x"></i>
                    </span>
                    '.$isDeleted.'
                </p>
            </div>';
            }
        return $output;
    }
}
