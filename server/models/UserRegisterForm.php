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
class UserRegisterForm extends Model
{
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
            ['password', 'compare', 'compareAttribute' => 'password_confirm'],
        ];
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
            return $user->save();
        }
        return false;
    }
}
