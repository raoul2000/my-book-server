<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

?>
<div>
    <p>Your Account has been created</p>
    <?php if ($activationRequired) : ?>

        <p>An activation email has been sent to <?= Html::encode($email) ?></p>

    <?php else : ?>

        <p>You can now  <?= Html::a('login', ['site/login']) ?></p>
        
    <?php endif ?>
</div>