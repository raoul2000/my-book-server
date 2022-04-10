<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\migrations\TableName;

/**
 * This is the model class for table "user_book".
 *
 * @property int $id
 * @property int $user_id
 * @property string $book_id
 * @property int $read_status
 * @property DateTime|null $read_at
 * @property int $rate
 * @property integer|null $created_at
 * @property integer|null $updated_at
 *
 * @property Book $book
 * @property User $user
 */
class UserBook extends \yii\db\ActiveRecord
{
    const READ_STATUS_TO_READ      = 1;
    const READ_STATUS_READ         = 2;
    const READ_STATUS_READING      = 3;
    const READ_STATUS_READ_AGAIN   = 4;

    /**
     * List of names for each status.
     * @var array
     */
    public static function getReadStatusList()
    {
        return [
            self::READ_STATUS_TO_READ     => 'To Read',
            self::READ_STATUS_READ        => 'Read',
            self::READ_STATUS_READING     => 'Reading',
            self::READ_STATUS_READ_AGAIN  => 'Read again'
        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return TableName::USER_BOOK;
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [[
            'class' => TimestampBehavior::class
        ]];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'book_id'], 'required'],
            [['user_id', 'read_status', 'rate'], 'integer'],
            [
                ['read_at'], 'date', 'format' => Yii::$app->formatter->dateFormat,   // 'php:Y-m-d H:i:s'
                'message' => 'Format de date invalide : '. Yii::$app->formatter->dateFormat
            ],             
            [['book_id'], 'string', 'max' => 40],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Book::class, 'targetAttribute' => ['book_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'book_id' => 'Book ID',
            'read_status' => 'Read Status',
            'read_at' => 'Read Date',
            'rate' => 'Rate',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Book]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBook()
    {
        return $this->hasOne(Book::class, ['id' => 'book_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
    /**
     * Required to be able to return the related book from REST API
     */
    public function extraFields()
    {
        return ['book'];
    }

    /**
     * Hides sensitive fields so they are not exposed to REST API
     */
    public function fields()
    {
        $fields = parent::fields();

        // remove fields that contain sensitive information
        unset($fields['id'], $fields['user_id']);
        
        return $fields;
    }
}
