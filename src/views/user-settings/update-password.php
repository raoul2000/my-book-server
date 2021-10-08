<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\forms\UpdatePasswordForm;

$this->title = 'Change le mot de passe';
$this->params['breadcrumbs'][] = ['label' => 'Paramètres', 'url' => ['/user-settings']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-register">
    <?php $form = ActiveForm::begin([
        'id' => 'update-pwd-form',
        'layout' => 'horizontal'
    ]); ?>

        <?php if($model->getScenario() === UpdatePasswordForm::SCENARIO_UPDATE) :?>
            <?= $form->field($model, 'old_password')->passwordInput() ?>
        <?php endif; ?>
        
        <?= $form->field($model, 'new_password')->passwordInput() ?>
        <?= $form->field($model, 'new_password_confirm')->passwordInput() ?>

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                <?= Html::submitButton('Enregistrer', ['class' => 'btn btn-primary', 'name' => 'register-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

</div>