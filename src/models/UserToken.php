<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "user_token".
 *
 * @property int $id
 * @property int $user_id
 * @property int $type
 * @property string $token
 * @property string|null $data
 * @property string|null $created_at
 * @property string|null $expire_at
 *
 * @property User $user
 */
class UserToken extends \yii\db\ActiveRecord
{
    /**
     * @var int Token for email activations (for registrations)
     */
    const TYPE_EMAIL_ACTIVATE = 1;

    /**
     * @var int Token for email changes (on /user/account page)
     */
    const TYPE_EMAIL_CHANGE = 2;

    /**
     * @var int Token for password resets
     */
    const TYPE_PASSWORD_RESET = 3;

    /**
     * @var int Token for logging in via email
     */
    const TYPE_EMAIL_LOGIN = 4;
    /**
     * @var string token to authenticate from app
     */
    const TYPE_API_KEY     = 5;

    public $tokenTypeList = [
        self::TYPE_EMAIL_ACTIVATE => 'email activate',
        self::TYPE_EMAIL_CHANGE => 'email change',
        self::TYPE_PASSWORD_RESET => 'password reset',
        self::TYPE_EMAIL_LOGIN => 'email login',
        self::TYPE_API_KEY => 'API Key',
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_token';
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
            [['user_id', 'type', 'token'], 'required'],
            [['user_id', 'type'], 'integer'],
            [['created_at', 'expire_at'], 'safe'],
            [['token', 'data'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'type' => 'Type',
            'token' => 'Token',
            'data' => 'Data',
            'created_at' => 'Created At',
            'expire_at' => 'Expire At',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Generate/reuse a userToken
     * 
     * @param int $userId
     * @param int $type
     * @param string $data
     * @param string $expireTime
     * @return static
     */
    public static function generate($userId, $type, $data = null, $expireTime = null)
    {
        // attempt to find existing record
        // otherwise create new
        $checkExpiration = false;
        if ($userId) {
            $model = static::findByUser($userId, $type, $checkExpiration);
        } else {
            $model = static::findByData($data, $type, $checkExpiration);
        }
        if (!$model) {
            $model = new static();
        }

        // set/update data
        $model->user_id = $userId;
        $model->type = $type;
        $model->data = $data;
        $model->expire_at = $expireTime;
        $model->token = Yii::$app->security->generateRandomString();
        $model->save();
        return $model;
    }    

    /**
     * Find a userToken by specified field/value
     * 
     * @param string $field
     * @param string $value
     * @param array|int $type
     * @param bool $checkExpiration
     * @return static
     */
    public static function findBy($field, $value, $type, $checkExpiration)
    {
        $query = static::find()->where([$field => $value, "type" => $type ]);
        if ($checkExpiration) {
            $now = gmdate("Y-m-d H:i:s");
            $query->andWhere("([[expire_at]] >= '$now' or [[expire_at]] is NULL)");
        }
        return $query->one();
    }

    /**
     * Find a userToken by userId
     * 
     * @param int $userId
     * @param array|int $type
     * @param bool $checkExpiration
     * @return static
     */
    public static function findByUser($userId, $type, $checkExpiration = true)
    {
        return static::findBy("user_id", $userId, $type, $checkExpiration);
    }

    /**
     * Find a userToken by token
     * 
     * @param string $token
     * @param array|int $type
     * @param bool $checkExpiration
     * @return static
     */
    public static function findByToken($token, $type, $checkExpiration = true)
    {
        return static::findBy("token", $token, $type, $checkExpiration);
    }

    /**
     * Find a userToken by data
     * 
     * @param string $data
     * @param array|int $type
     * @param bool $checkExpiration
     * @return static
     */
    public static function findByData($data, $type, $checkExpiration = true)
    {
        return static::findBy("data", $data, $type, $checkExpiration);
    }    
}
