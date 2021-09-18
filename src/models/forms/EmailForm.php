<?php

namespace app\models\forms;

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
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Recipient Name',
            'email' => 'Recipient Email',
            'body' => "Text",
        ];
    }
    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function sendEmail()
    {
        return Yii::$app->mailer->compose(
            [
                'html' => 'test-html',
                'text' => 'test-text',
            ],
            [
                'body' => $this->body
            ]
        )
            ->setTo([$this->email => $this->name])
            //->setTo('manu34@free.fr')
            ->setFrom([$this->getSenderEmail() => $this->getSenderName()])
            //->setFrom('Raoul@ass-team.fr')
            ->setReplyTo([$this->getSenderEmail() => $this->getSenderName()])
            ->setSubject($this->subject)
            ->send();
    }
    public function getSenderName()
    {
        return Yii::$app->params['senderName'];
    }
    public function getSenderEmail()
    {
        return Yii::$app->params['senderEmail'];
    }
}
