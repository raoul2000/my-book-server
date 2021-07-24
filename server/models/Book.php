<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "books".
 *
 * @property string $id
 * @property string $title
 * @property string|null $author
 */
class Book extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book';
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
            [['id', 'title'], 'required'],
            [['id'], 'string', 'max' => 32],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'author'], 'string', 'max' => 255],
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
            'title' => 'Title',
            'author' => 'Author',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getPings()
    {
        return $this->hasMany(BookPing::class, ['book_id' => 'id']);
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

    public function getReviews()
    {
        return $this->hasMany(BookReview::class, ['book_id' => 'id']);
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
