<?php

namespace app\models\forms;

use Yii;
use app\models\User;
use yii\base\Model;

/**
 * Handle both password update and password Reset actions
 */
class UpdatePasswordForm extends Model
{
    const SCENARIO_RESET  = 'reset';
    const SCENARIO_UPDATE = 'update';

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
            [['old_password'], 'required', 'on' => [self::SCENARIO_UPDATE]],
            [['new_password', 'new_password_confirm'], 'required', 'on' =>  [self::SCENARIO_UPDATE, self::SCENARIO_RESET]],
            ['new_password_confirm', 'compare', 'compareAttribute' => 'new_password', 'on' =>  [self::SCENARIO_UPDATE, self::SCENARIO_RESET]],
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

    public function updatePassword($userId = null)
    {
        if ($this->getScenario() === self::SCENARIO_RESET && $userId === null) {
            throw new \Exception('missing user id');
        }

        if ($this->validate()) {

            $actualUserId = $userId !== null
                ? $userId
                : Yii::$app->user->getId();

            $user =  User::findOne($actualUserId);
            $user->setScenario(User::SCENARIO_UPDATE_PASSWORD);

            if ($this->getScenario() === self::SCENARIO_UPDATE &&  $user->validatePassword($this->old_password) === false) {
                $this->addError('old_password', 'mot de passe incorrect');
            } else {
                $user->new_password = $this->new_password;
                return $user->save();
            }
        }
        return false;
    }
}
