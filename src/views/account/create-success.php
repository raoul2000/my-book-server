<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
$alertType = $activationRequired 
    ? 'alert-info'
    : 'alert-success';
?>

<div class="alert <?= $alertType?>" role="alert">
    <p><strong>Félicitation !! </strong>Votre compte a été créé.</p>
    <?php if ($activationRequired) : ?>

        <p>Avant de pouvoir vous connecter vous devrez <strong>activer votre compte</strong>. Pour 
        cela, un email vous a été envoyé à l'adresse <?= Html::encode($email) ?></p>

    <?php else : ?>

        <p>Vous pouvez maintenant vous <?= Html::a('connecter', ['site/login']) ?></p>
        
    <?php endif ?>
</div>    
