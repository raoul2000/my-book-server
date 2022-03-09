<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
$alertType = $activationRequired 
    ? 'alert-info'
    : 'alert-success';
$this->title = 'Créer mon compte';
?>

<div class="alert <?= $alertType?>" role="alert">
    <p><strong>Félicitation !! </strong>Votre compte a été créé.</p>
    <?php if ($activationRequired) : ?>
        <p>Avant de pouvoir vous connecter vous devrez <strong>activer votre compte</strong>. Pour 
        cela, un email vous a été envoyé à l'adresse <em><?= Html::encode($email) ?></em>, il contient le lien d'activation.</p>
    <?php else : ?>
        <p>Vous pouvez maintenant vous <?= Html::a('connecter', ['site/login']) ?></p>
    <?php endif ?>
</div>  

<?php if ($activationRequired) : ?>
    <div class="alert alert-warning" role="alert">
        <p><span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span> si vous ne trouvez pas de l'email d'activation dans
        votre boîte de réception, vérifiez dans votre dossier des emails "indésirables" (spam)</p>
    </div>
<?php endif ?>    
