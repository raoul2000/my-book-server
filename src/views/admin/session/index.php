<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchSession */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sessions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="session-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Session', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'expire:datetime',
            'data',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
