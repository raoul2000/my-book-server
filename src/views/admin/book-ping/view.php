<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\BookPing */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Book Ping', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="book-ping-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr/>
    
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
            'book_id',
            'is_boarding:boolean',
            'book.title',
            'text:ntext',
            'rate',
            'location_name',
            'email',    
            'user_ip',
            'created_at:datetime',        
            'updated_at:datetime',
        ],
    ]) ?>

</div>
