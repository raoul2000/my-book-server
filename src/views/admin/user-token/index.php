<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchUserToken */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Tokens';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-token-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr />

    <p>
        <?= Html::a('Create User Token', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'user_id',
            [
                'attribute' => 'type',
                'label'     => 'Type',
                'filter'    => $searchModel->tokenTypeList,
                'value'     => function ($model, $key, $index, $column) use ($searchModel) {
                    return $model->type != null
                        ? Html::encode($searchModel->tokenTypeList[$model->type])
                        : null;
                }
            ],
            'token',
            'data',
            'created_at',
            'expire_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>