<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
$this->title = 'User Settings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-settings">

    <h1>User Settings</h1>
    <hr/>
    
    <div class="grid">
        <div class="row">
            <div class="col-sm-2"><strong>Username</strong></div>
            <div class="col-sm-10"><?= $userModel->username ?></div>
        </div>
        <div class="row">
            <div class="col-sm-2"><strong>Email</strong></div>
            <div class="col-sm-10"><?= $userModel->email ?></div>
        </div>
        <div class="row">
            <div class="col-sm-2"><strong>Password</strong></div>
            <div class="col-sm-10"><?= Html::a('update password', ['user-settings/update-password'])?></div>
        </div>
        <div class="row">
            <div class="col-sm-2"><strong>API Key</strong></div>
            <div class="col-sm-10">
                
                <?php if(!empty($qrCode)): ?>
                    <?= $apiKey->token ?><br/>
                    <img src="<?=  $qrCode->writeDataUri()?>" title="api key : QR code" alt="api key qr code"/>
                <?php else: ?>
                    <em>no set</em>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>

