<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserBook */

$this->title = 'Create User Book';
$this->params['breadcrumbs'][] = ['label' => 'User Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-book-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr/>
    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
