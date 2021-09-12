<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
?>
<div class="tracker-form">
    <h1>Oups ! </h1>
    <div class="intro">
        <?= $message ?><br />
        <p>
            <?= Html::a('réessayer', ['/book-ping']) ?>
        </p>
    </div>
</div>