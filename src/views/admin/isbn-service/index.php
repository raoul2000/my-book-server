<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\VarDumper;

$this->title = 'ISBN Service';
?>
<div>
    <h1><?= Html::encode($this->title) ?> <small>Test</small></h1>
    <hr/>

    <?php $form = ActiveForm::begin([
        'id' => 'isbn-service-form',
        'layout' => 'horizontal'
    ]); ?>

        <?= $form->field($model, 'isbn_number')->textInput() ?>

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                <?= Html::submitButton('Send Request ', ['class' => 'btn btn-primary', 'name' => 'send-request-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>
    <?php if($bookInfo): ?>
        <pre>
            <?= VarDumper::dumpAsString($bookInfo) ?>
        </pre>
    <?php endif; ?>

</div>