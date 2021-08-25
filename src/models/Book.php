<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use \thamtech\uuid\helpers\UuidHelper;
use app\migrations\TableName;

/**
 * This is the model class for table "books".
 *
 * @property string $id
 * @property string $title
 * @property string $subtitle
 * @property string|null $author
 * @property string|null $isbn
 * @property int|null $is_traveling
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Book extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return TableName::BOOK;
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [[
            'class' => TimestampBehavior::className(),
            'value' => new Expression('NOW()'),
        ]];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['isbn'], 'string', 'max' => 15],
            [['is_traveling'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'subtitle', 'author'], 'trim'],
            [['title', 'subtitle', 'author'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'title' => 'Title',
            'subtitle' => 'Sub Title',
            'author' => 'Author',
            'isbn' => 'ISBN',
            'is_traveling' => 'Is Traveling',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        if ($insert) {
            $this->id = UuidHelper::uuid();
        }
        return true;
    }
    /**
     * Gets query for [[BookPings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPings()
    {
        return $this->hasMany(BookPing::class, ['book_id' => 'id']);
    }

    /**
     * Gets query for [[BookReviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(BookReview::class, ['book_id' => 'id']);
    }

    /**
     * Gets query for [[UserBooks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserBooks()
    {
        return $this->hasMany(UserBook::className(), ['book_id' => 'id']);
    }

    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'book_id'])
            ->via('userBooks');
    }


    public function getPingsCount()
    {
        //TODO: requires extra query - could be optimized (or not used)
        if ($this->isNewRecord) {
            return null; // this avoid calling a query searching for null primary keys
        }

        return empty($this->pingsAggregation) ? 0 : $this->pingsAggregation[0]['counted'];
    }

    /**
     * Declares new relation based on 'orders', which provides aggregation.
     */
    public function getPingsAggregation()
    {
        return $this->getPings()
            ->select(['book_id', 'counted' => 'count(*)'])
            ->groupBy('book_id')
            ->asArray(true);
    }

    public function getReviewsCount()
    {
        if ($this->isNewRecord) {
            return null; // this avoid calling a query searching for null primary keys
        }

        return empty($this->reviewsAggregation) ? 0 : $this->reviewsAggregation[0]['counted'];
    }
    public function getReviewsAggregation()
    {
        return $this->getReviews()
            ->select(['book_id', 'counted' => 'count(*)'])
            ->groupBy('book_id')
            ->asArray(true);
    }
}
