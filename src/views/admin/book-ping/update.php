<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BookPing */

$this->title = 'Update Book Ping: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Book Pings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="book-ping-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr/>
    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
