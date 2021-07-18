<?php
/* @var $this yii\web\View */
$this->title = 'User Settings';
?>
<div class="user-settings">

    <h1>User Settings</h1>
    <hr/>
    <div class="grid">
        <div class="row">
            <div class="col-sm-2">Username</div>
            <div class="col-sm-10"><?= $userModel->username ?></div>
        </div>
        <div class="row">
            <div class="col-sm-2">Email</div>
            <div class="col-sm-10"><?= $userModel->email ?></div>
        </div>
    </div>
</div>

