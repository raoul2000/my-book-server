<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchUserBook */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Books';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-book-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr/>
    
    <p>
        <?= Html::a('Create User Book', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'id',
            'user_id',
            'book_id',
            'created_at',
            'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
