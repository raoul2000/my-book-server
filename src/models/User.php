<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use app\migrations\TableName;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property int $status
 * @property integer|null $created_at
 * @property integer|null $updated_at
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    const SCENARIO_REGISTER        = 'register';
    const SCENARIO_UPDATE_PASSWORD = 'update_pwd';

    const STATUS_ACTIVE   = 10;
    const STATUS_INACTIVE = 1;
    const STATUS_DELETED  = 0;

    /**
     * List of names for each status.
     * @var array
     */
    public static function getStatusList()
    {
        return         [
            self::STATUS_ACTIVE   => 'Active',
            self::STATUS_INACTIVE => 'Inactive',
            self::STATUS_DELETED  => 'Deleted'
        ];
    }

    public $new_password;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return TableName::USER;
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
            [['username', 'email'], 'required'],
            [['new_password'], 'required', 'on' => [self::SCENARIO_REGISTER, self::SCENARIO_UPDATE_PASSWORD]],
            [['username', 'email', 'new_password'], 'string', 'max' => 255],
            [['username', 'email'], 'unique'],
            ['status', 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'email' => 'Email',
            'password_hash' => 'Password Hash',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status'
        ];
    }

    /**
     * Gets query for [[UserBooks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserBooks()
    {
        return $this->hasMany(UserBook::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UserTokens]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserTokens()
    {
        return $this->hasMany(UserToken::className(), ['user_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        if ($this->getScenario() == self::SCENARIO_REGISTER || $this->getScenario() == self::SCENARIO_UPDATE_PASSWORD) {
            $this->password_hash = Yii::$app->security->generatePasswordHash($this->new_password);
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Finds user by username.
     *
     * @param  string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * Finds user by email.
     *
     * @param  string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
    }
    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }
    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $userToken = UserToken::find()
            ->where([
                'type'  => UserToken::TYPE_API_KEY,
                'token' => $token
            ])
            ->with('user')
            ->one();

        return $userToken
            ? $userToken->user
            : null;
    }
    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
    }
    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
    }
}
