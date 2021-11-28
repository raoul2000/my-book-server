<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
$this->title = 'Paramètres';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-settings">
    <p>
        <?= Html::a('Exporter mes livres', ['/export-books'], ['class' => 'btn btn-success']) ?>
        <?php if( Yii::$app->user->id === 1): ?>
            <?= Html::a('Import Books as CSV', ['/import-book'], ['class' => 'btn btn-success']) ?>
        <?php endif; ?>
    </p>
    <hr/>
    <div class="grid">
        <div class="row">
            <div class="col-sm-2"><strong>Pseudo</strong></div>
            <div class="col-sm-10"><?= $userModel->username ?></div>
        </div>
        <div class="row">
            <div class="col-sm-2"><strong>Email</strong></div>
            <div class="col-sm-10"><?= $userModel->email ?></div>
        </div>
        <div class="row">
            <div class="col-sm-2"><strong>Mot de passe</strong></div>
            <div class="col-sm-10"><?= Html::a('changer mot de passe', ['user-settings/update-password'])?></div>
        </div>
        <div class="row">
            <div class="col-sm-2"><strong>Clé API</strong></div>
            <div class="col-sm-10">
                <?php if(!empty($apiKey)): ?>
                    disponible
                <?php else: ?>
                    <em>indisponible</em>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>

