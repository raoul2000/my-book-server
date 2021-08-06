<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user This property is read-only.
 *
 */
class UserRegistrationForm extends Model
{
    private $user_id;
    private $account_activation_token;
    public $username;
    public $email;
    public $password;
    public $password_confirm;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username', 'password', 'password_confirm', 'email'], 'required'],
            ['username', 'unique', 'targetClass' => User::class, 'targetAttribute' => 'username'],
            ['email', 'unique', 'targetClass' => User::class, 'targetAttribute' => 'email'],
            ['email', 'email'],
            ['password_confirm', 'compare', 'compareAttribute' => 'password'],
        ];
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getAccountActivationToken()
    {
        return $this->account_activation_token;
    }

    /**
     * Register a user using the provided data.
     * @return bool registration failure or success
     */
    public function register()
    {
        if ($this->validate()) {

            $user = new User();
            
            $user->setScenario(User::SCENARIO_REGISTER);

            $user->username     = $this->username;
            $user->email        = $this->email;
            $user->new_password = $this->password;
            $user->status       = User::STATUS_ACTIVE;

            $success = false;
            if($user->save()) {

                $this->user_id = $user->id; // expose to caller

                if (Yii::$app->params['enableAccountActivation']) {
                    $user->status = User::STATUS_INACTIVE;
                    $userToken    = UserToken::generate($user->id, UserToken::TYPE_EMAIL_ACTIVATE);
                    $this->account_activation_token = $userToken->token;
                    $success = $user->update(true, ['status']) === 1;
                } 
            } else {
                $this->addErrors($user->getErrors());
            }

            if(!$success) {
                $this->account_activation_token = '';
                $this->password = '';
                $this->password_confirm = '';
            }
            return $success;
        }
    }
}
