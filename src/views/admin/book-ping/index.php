<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchBookPing */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Book Pings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-ping-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr/>
    
    <?php if(!$savePingEnabled): ?>
        <div class="alert alert-danger">La sauvegarde des Pings est actuellement <b>désactivée</b></div>
    <?php endif; ?>

    <p>
        <?= Html::a('Create Book Ping', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'book_id',
            'book.title',
            'user_ip',
            'created_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
