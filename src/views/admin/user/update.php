<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Update User: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-update">

    <h1>
        <span class="glyphicon glyphicon-user" aria-hidden="true"></span>     
        <?= Html::encode($this->title) ?>
    </h1>
    <hr/>
    
    <?= $this->render('_form', [
        'model' => $model,
        'forCreate' => false
    ]) ?>

</div>
