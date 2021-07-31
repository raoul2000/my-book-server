<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BookReview */

$this->title = 'Create Book Review';
$this->params['breadcrumbs'][] = ['label' => 'Book Reviews', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-review-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
