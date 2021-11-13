<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>
<p>
    Bonjour <?= Html::encode($username) ?><br/>
    Pour activer votre compte, cliquez sur le lien suivant:<br/>
    <br/>
    <strong><?= Html::a('Activer Mon Compte', $activationUrl ) ?></strong>
</p>


