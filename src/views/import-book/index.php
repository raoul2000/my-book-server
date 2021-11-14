<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;

$totalProcessed = count($records_created) + count($records_error);

/* @var $this yii\web\View */
?>
<div class="import-book">
    <h1>Import Book List</h1>
    <hr />
    <div class="row">
        <div class="col-lg-12">
            <?php if ($totalProcessed === 0) : ?>

                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
                    <?= $form->field($model, 'dataFile')->fileInput() ?>
                    <?= Html::submitButton('Import', ['class' => 'btn btn-primary']) ?>
                <?php ActiveForm::end() ?>

            <?php else : ?>
                <p>
                    <?= Html::a('Import Other CSV file', ['/import-book'], ['class' => 'btn btn-success']) ?>
                </p>
                <?php if (isset($records_created) && count($records_created) !== 0) : ?>
                    <h2>Books Imported</h2>
                    <?= GridView::widget([
                        'dataProvider' => new ArrayDataProvider([
                            'allModels' => $records_created,
                            'sort' => [
                                'attributes' => ['id', 'username', 'email'],
                            ],
                            'pagination' => false,
                        ]),
                        'columns' => [
                            'title',
                            'author',
                            'isbn',
                        ],
                    ]); ?>
                <?php endif; ?>

                <?php if (isset($records_error) && count($records_error) !== 0) : ?>
                    <h2>Errors</h2>
                    <?= GridView::widget([
                        'dataProvider' => new ArrayDataProvider([
                            'allModels' => $records_error,
                            'sort' => [
                                'attributes' => ['id', 'username', 'email'],
                            ],
                            'pagination' => false,
                        ]),
                        'columns' => [
                            'message',
                            'reason',
                            'record',
                        ],
                    ]); ?>
                <?php endif; ?>

            <?php endif; ?>
        </div>

    </div>
</div>