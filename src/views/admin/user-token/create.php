<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserToken */

$this->title = 'Create User Token';
$this->params['breadcrumbs'][] = ['label' => 'User Tokens', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-token-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr/>
    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
