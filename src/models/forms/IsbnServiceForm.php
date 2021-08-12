<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class IsbnServiceForm extends Model
{
    public $isbn_number;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['isbn_number'], 'required'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'isbn_number' => 'ISBN Number',
        ];
    }
}
