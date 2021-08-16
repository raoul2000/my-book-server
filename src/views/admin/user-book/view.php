<?php

use app\models\UserBook;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\UserBook */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-book-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr />

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'book_id',
            [
                'label' => 'Read Status',
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->read_status) {
                        return UserBook::getReadStatusList()[$model->read_status];
                    }
                }
            ],
            [
                'label' => 'Rate',
                'format' => 'raw',
                'value' => function ($model) {
                    if (isset($model->rate)) {
                        return  \yii2mod\rating\StarRating::widget([
                            'name' => 'book_rate',
                            'value' => $model->rate,
                            'clientOptions' => [
                                'readOnly' => true
                            ],
                        ]);
                    }
                }
            ],
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>