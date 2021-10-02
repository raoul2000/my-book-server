<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchBookPing */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Book Ping';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-ping-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr/>
    
    <p>
        <?= Html::a('Create Book Ping', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'book_id',
            'is_boarding:boolean',
            'book.title',
            'text:ntext',
            'rate',
            'location_name',
            'email',
            'user_ip',
            'updated_at:datetime',
            
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
