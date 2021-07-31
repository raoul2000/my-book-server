<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "{{%book_review}}".
 *
 * @property int $id
 * @property string $book_id
 * @property string $text
 *
 * @property Book $book
 */
class BookReview extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%book_review}}';
    }
    
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [[
            'class' => TimestampBehavior::className(),
            'updatedAtAttribute' => false,
            'value' => new Expression('NOW()'),
        ]];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['book_id' ], 'required'],
            [['book_id'], 'string', 'max' => 32],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Book::className(), 'targetAttribute' => ['book_id' => 'id']],
            [['user_ip'], 'string', 'max' => 50],
            [['text'], 'string'],
            [['rate'], 'integer'],
            [['created_at'], 'safe'],
            [['location_name', 'email'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'book_id' => 'Book ID',
            'email' => "Email",
            'rate' => 'Rate',
            'text' => 'Text',
            'location_name' => 'Location',
            'created_at' => 'Created At',
            'user_ip' => 'User IP'
        ];
    }

    /**
     * Gets query for [[Book]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBook()
    {
        return $this->hasOne(Book::className(), ['id' => 'book_id']);
    }
}
