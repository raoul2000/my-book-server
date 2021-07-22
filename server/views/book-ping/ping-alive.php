<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BookReview */
/* @var $form ActiveForm */
?>
<div class="book-ping">
    <h1>
        <?= Html::encode($book->title) ?><br/>
        <small><?= Html::encode($book->author)?></small>
    </h1>

    <p>
        You may change the content of this page by modifying
        the file <code><?= __FILE__; ?></code>.
    </p>
    <div class="book-review">
        <?php $form = ActiveForm::begin(); ?>


            <?= $form->field($bookReview, 'text')->textarea(['rows' => 6])->label('')  ?>


            <div class="form-group">
                <?= Html::submitButton('Envoyer', ['class' => 'btn btn-primary btn-submit-review']) ?>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
