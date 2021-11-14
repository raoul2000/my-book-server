<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
?>
<div class="tracker-form">
    <h1>Oups ! </h1>
    <div class="intro">
        <?= $message ?><br />
        <p style="margin-top:2em;">
            <?= Html::a('réessayer', ['/book-ping'],['class' => 'btn btn-primary']) ?>
            <?= Html::a('en savoir plus', ['/'], ['class' => 'btn btn-default'])?>
        </p>
    </div>
</div>