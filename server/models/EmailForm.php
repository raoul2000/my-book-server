<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class EmailForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'subject', 'body'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],

        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function contact($email)
    {
        if ($this->validate()) {
            Yii::$app->mailer->compose(
                [
                    'html' => 'test-html',
                    'text' => 'test-text',
                ],
                [
                    'body' => $this->body
                ]
            )
                ->setTo('manu34@free.fr')
                //->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
                ->setFrom('Raoul@ass-team.fr')
                ->setReplyTo([$this->email => $this->name])
                ->setSubject($this->subject)
                ->send();

            return true;
        }
        return false;
    }
}
