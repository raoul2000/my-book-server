<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BookReview */

$this->title = 'Update Book Review: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Book Reviews', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="book-review-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
