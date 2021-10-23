<?php

namespace app\components;

use yii\validators\Validator;

class PasswordValidator extends Validator
{
    const PWD_MIN_LENGTH   = 6;
    
    public function validateAttribute($model, $attribute)
    {
        $password = $model->$attribute;
        if (empty($password)) {
            $this->addError($model, $attribute, 'Le mot de passe doit être renseigné');
        } elseif (strlen($password) < self::PWD_MIN_LENGTH) {
            $this->addError($model, $attribute, 'Le mot de passe doit contenir au moins {min_len} caractères', ['min_len' => self::PWD_MIN_LENGTH]);
        } elseif (!preg_match('/[A-Z]/', $password)) {
            $this->addError($model, $attribute, 'Le mot de passe doit contenir au moins un caractère majuscule');
        } elseif (!preg_match('/[a-z]/', $password)) {
            $this->addError($model, $attribute, 'Le mot de passe doit contenir moins un caractère minuscule');
        } elseif (!preg_match('/[0-9]/', $password)) {
            $this->addError($model, $attribute, 'Le mot de passe doit contenir moins un chiffre');
        }
    }
}
