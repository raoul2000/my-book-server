<?php

use app\models\UserBook;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserBook */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-book-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'book_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'read_status')
        ->dropDownList(UserBook::getReadStatusList(), ['prompt' => \Yii::t('app', 'select status ...')]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
