<?php

namespace app\models;

use app\migrations\TableName;
/**
 * This is the model class for table "{{%session}}".
 *
 * @property string $id
 * @property int|null $expire
 * @property resource|null $data
 */
class Session extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return TableName::SESSION;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['expire'], 'integer'],
            [['data'], 'string'],
            [['id'], 'string', 'max' => 40],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'expire' => 'Expire',
            'data' => 'Data',
        ];
    }
}
