<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii2mod\rating\StarRating;

/* @var $this yii\web\View */
/* @var $model app\models\BookPing */
/* @var $form ActiveForm */
?>
<div class="tracker-form">
    <div class="grid">
        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-sm-12">
                <h3>Livre Voyageur</h3>
                <p>Vous êtes ici parce qu'un livre voyageur est passé entre vos mains.</p>
                <p>Entrez le <em>numéro de réservation</em> que vous trouverez en évidence dans le livre et validez.
                    Cela permettra à la personne qui était au départ du voyage d'avoir des nouvelles de son livre.
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">

                <?= $form->field($model, 'booking_number')
                    ->textInput(['placeholder' => 'XXX-XXX', 'autocomplete' => 'off', 'class' => 'form-control input-lg book-num'])
                    ->label('Numéro de Réservation')
                ?>
                <div class="form-group">
                    <?= Html::submitButton('Valider', ['class' => 'btn btn-primary btn-submit-review']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>