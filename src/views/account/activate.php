<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
$this->title = 'Activer mon compte';
?>
<?php if ($success): ?>
    <div class="alert alert-success">
        <p>Compte activé : vous pouvez maintenant vous <?= Html::a('connecter', ['site/login']) ?></p>
    </div>
<?php else: ?>
    <div class="alert alert-danger">
        <p>Ce compte n'a pu être activé</p>    
    </div>
<?php endif ?>
