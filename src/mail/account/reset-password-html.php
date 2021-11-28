<?php
use yii\helpers\Html;
?>
<p>
    Une demande de réinitialisation de votre mot de passe pour votre compte a été faite. <br/>
    Vous pouvez maintenant réinitialiser votre mot de passe en cliquant sur le lien ci-dessous ou en le copiant dans votre navigateur : <br/>
    <?= Html::a($resetPasswordUrl, $resetPasswordUrl ) ?>
</p>


