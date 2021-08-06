<?php

namespace app\models\forms;

use Yii;
use app\models\User;
use yii\base\Model;


class UpdatePasswordForm extends Model
{
    public $old_password;
    public $new_password;
    public $new_password_confirm;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['old_password', 'new_password', 'new_password_confirm'], 'required'],
            ['new_password_confirm', 'compare', 'compareAttribute' => 'new_password'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'old_password' => 'Mot de passe',
            'new_password' => 'Nouveau mot de passe',
            'new_password_confirm' => 'Confimer le nouveau mot de passe',
        ];
    }

    public function updatePassword()
    {
        if ($this->validate()) {

            $user = User::findOne(Yii::$app->user->getId());
            $user->setScenario(User::SCENARIO_UPDATE_PASSWORD);

            if($user->validatePassword($this->old_password) === false) {
                $this->addError('old_password','mot de passe incorrect');
            } else {
                $user->new_password = $this->new_password;
                return $user->save();
            }
        }
        return false;
    }
}
