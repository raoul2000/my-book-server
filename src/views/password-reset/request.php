<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Reset Password';
?>
<div>
    <h1><?= Html::encode($this->title) ?></h1>
    <hr/>
    <?php $form = ActiveForm::begin([
        'id' => 'pwd-reset-form',
        'layout' => 'horizontal'
    ]); ?>

        <?= $form->field($model, 'email')->textInput(['autocomplete' => 'off']) ?>

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                <?= Html::submitButton('Reset ', ['class' => 'btn btn-primary', 'name' => 'reset-pwd-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

</div>
