<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BookTicket */

$this->title = 'Create Book Ticket';
$this->params['breadcrumbs'][] = ['label' => 'Book Tickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-ticket-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
