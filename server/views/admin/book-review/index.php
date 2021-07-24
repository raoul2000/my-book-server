<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchBookReview */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Book Reviews';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-review-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Book Review', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'book_id',
            'book.title',
            'text:ntext',
            'rate',
            'location_name',
            'email',
            'user_ip',
            'created_at',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
