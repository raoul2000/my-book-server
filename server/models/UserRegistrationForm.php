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
    /**
     * Register a user using the provided data.
     * @return bool whether the user is registered successfully
     */
    public function register()
    {
        if ($this->validate()) {
            $user = new User();
            $user->setScenario(User::SCENARIO_REGISTER);
            $user->username = $this->username;
            $user->email = $this->email;
            $user->new_password = $this->password;
            if ($user->validate()) {
                $saveSuccess = $user->save(false);
                $this->user_id = $user->id;
                return $saveSuccess;
            } else {
                $this->addErrors($user->getErrors());
            }
        }
        $this->password = '';
        $this->password_confirm = '';
        return false;
    }
}
