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
            ['booking_number', 'validateBookingNumber'],
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

    public function validateBookingNumber($attribute, $params, $validator)
    {
        if (self::normalizeTicketId($this->$attribute) === null) {
            $this->addError($attribute, 'format invalide');
        }
    }
    /**
     * Converts ticket id into format 'XXX-XXX' where X is a number or an upper-case letter.
     * If the ticket ID could not be normalized, returns NULL
     */
    public static function normalizeTicketId($ticketId)
    {
        $normalizedTicketId = null;
        $re = '/^([[:alnum:]][[:alnum:]][[:alnum:]])[-_\.]?([[:alnum:]][[:alnum:]][[:alnum:]])$/';

        preg_match_all($re, $ticketId, $matches, PREG_SET_ORDER, 0);
        if (count($matches) === 1) {
            $normalizedTicketId = strtoupper($matches[0][1]) . '-' . strtoupper($matches[0][2]);
        }
        return $normalizedTicketId;
    }   

}
