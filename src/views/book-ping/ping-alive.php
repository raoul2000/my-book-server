<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii2mod\rating\StarRating;

/* @var $this yii\web\View */
/* @var $model app\models\BookPing */
/* @var $form ActiveForm */
?>
<div class="book-ping">
    <div class="intro">
        Laissez une trace dans le voyage de ce livre ...
    </div>
    <h2>
        <?= Html::encode($book->title) ?><br />
        <small><?= Html::encode($book->author) ?></small>
    </h2>

    <div class="book-ping">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($bookReview, 'rate', ['template' => '{input}'])->widget(StarRating::class, [
            'options' => [
                'label' => '',
                'title' => 'rate',
                'class' => '',                
            ],
            'clientOptions' => [
                'number' => 5
            ],
        ]); ?>
        <?= $form->field($bookReview, 'text')->textarea(['rows' => 3, 'placeholder' => 'votre avis sur ce livre...'])->label('')  ?>

        <div class="grid">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($bookReview, 'location_name')
                        ->textInput(['placeholder' => 'où l\'avez-vous trouvé ?', 'autocomplete' => 'off'])
                        ->label('')
                        ->hint('comment est-il arrivé jusqu\'à vous ?') ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($bookReview, 'email')
                        ->textInput(['placeholder' => 'votre adresse email ?', 'autocomplete' => 'off'])
                        ->label('')
                        ->hint('Votre adresse email ne sera utilisée que pour vous envoyer des nouvelles de ce livre dans la suite de son voyage') ?>
                </div>
            </div>
        </div>
        <div class="outro">
            ... et aidez-le à poursuivre sa route vers son prochain lecteur.
        </div>
        <div class="form-group">
            <?= Html::submitButton('Enregistrer', ['class' => 'btn btn-primary btn-submit-review']) ?>
        </div>
        <?php ActiveForm::end(); ?>



    </div>
</div>