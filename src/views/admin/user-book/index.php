<?php

use app\models\UserBook;
use yii\helpers\Html;
use yii\grid\GridView;

$readStatusList = UserBook::getReadStatusList();
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
            [
                'attribute' => 'read_status',
                'label'     => 'Read Status',
                'filter'    => $readStatusList,
                'value'     => function ($model) use ($readStatusList) {
                    return $model->read_status != null
                        ? Html::encode($readStatusList[$model->read_status])
                        : null;
                }
            ],
            'read_at',
            'rate',
            'updated_at:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
