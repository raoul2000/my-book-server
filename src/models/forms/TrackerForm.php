<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class TrackerForm extends Model
{
    public $booking_number;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['booking_number'], 'required' ,'message' => ''],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'booking_number' => 'Booking number',
        ];
    }
}
