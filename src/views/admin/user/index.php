<?php

use app\models\User;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1>
        <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
        <?= Html::encode($this->title) ?>
    </h1>
    <hr />

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'username',
            'email:email',
            [
                'attribute' => 'status',
                'label'     => 'Status',
                'filter'    => $searchModel->statusList,
                'value'     => function ($model, $key, $index, $column) use ($searchModel) {
                    return $model->status != null
                        ? Html::encode($searchModel->statusList[$model->status])
                        : null;
                }
            ],
            'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>