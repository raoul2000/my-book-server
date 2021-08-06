<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserBook */

$this->title = 'Update User Book: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-book-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
