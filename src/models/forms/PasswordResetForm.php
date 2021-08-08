<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\User;
use app\models\UserToken;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user This property is read-only.
 *
 */
class PasswordResetForm extends Model
{
    public $email;
    private $_password_reset_token;

    /**
     * @var $_user app\models\User
     */
    private $_user;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'validateEmail'],
        ];
    }
    public function getPasswordResetToken()
    {
        return $this->_password_reset_token;
    }

    public function validateEmail($attribute, $params)
    {
        $this->_user = null;
        if (!$this->hasErrors()) {
            $user = User::findOne([
                'status' => User::STATUS_ACTIVE,
                'email'  => $this->$attribute
            ]);

            if (!$user) {
                $this->addError($attribute, 'Invalid email');
            } else {
                $this->_user = $user;
            }
        }
    }

    public function resetPassword()
    {
        if ($this->validate()) {
            $userToken = UserToken::generate($this->_user->id, UserToken::TYPE_PASSWORD_RESET);
            $this->_password_reset_token =  $userToken->token;
            return true;
        }
        return false;
    }
}
