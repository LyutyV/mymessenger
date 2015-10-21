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

    public static function records($userId, $user2Id) {
        return static::findBySql("SELECT * FROM `chat` WHERE userId = ".$userId." AND user2Id = ".$user2Id."
                                    OR userId = ".$user2Id." AND user2Id = ".$userId." ORDER BY id DESC LIMIT 10")->all();
    }

    public static function allUsers() {
        return static::find()->orderBy('id desc')->all();
    }

    public function users() {
        $output = '';
        $allUsers = User::getAllUsers();
        if ($allUsers) {
            foreach ($allUsers as $userItem) {
                //if ($userItem->username == $currentUser) continue;

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
                $output['chat'] .= '<div class="item">
                <!--<img class="online" alt="user image" src="' . $avatar . '">-->
                <p class="message">
                    <a class="name" href="#">
                        <small class="text-muted pull-right" style="color:green"><i class="fa fa-clock-o"></i> ' . \kartik\helpers\Enum::timeElapsed($model->updateDate) . '</small>
                        ' . $model->user->username . '
                    </a>
                    ' . $model->message . '
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary" id="editButton" data-id="'.$model->id.'"><i class="fa fa-pencil fa-fw"></i></button>
                        <button type="button" class="btn btn-danger" id="deleteButton" data-id="'.$model->id.'"><i class="fa fa-trash-o fa-lg"></i></button>
                   </div>
                </p>
            </div>';
            }
        return $output;
    }

    // public function getNewItem() {
    //     $output = '';

    //     $output .= '<div class="item">
    //     <!--<img class="online" alt="user image" src="' . $avatar . '">-->
    //     <p class="message">
    //         <a class="name" href="#">
    //             <small class="text-muted pull-right" style="color:green"><i class="fa fa-clock-o"></i> ' . \kartik\helpers\Enum::timeElapsed($this->updateDate) . '</small>
    //             ' . $this->user->username . '
    //         </a>
    //         ' . $this->message . '
    //         <div class="btn-group">
    //             <button type="button" class="btn btn-primary" id="editButton" data-url="" data-model=""><i class="fa fa-pencil fa-fw"></i></button>
    //             <button type="button" class="btn btn-danger" id="deleteButton" data-url="" data-model=""><i class="fa fa-trash-o fa-lg"></i></button>
    //        </div>
    //     </p>
    //     </div>';
        
    //     return $output;
    // }

}
