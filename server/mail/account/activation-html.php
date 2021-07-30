<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>
<p>
hello <?= Html::encode($username) ?><br/>
<?= Html::a('Account Activation', $activationUrl ) ?>
</p>


