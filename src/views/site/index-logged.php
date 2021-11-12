<?php


use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = 'Mes Livres';
if ($totalBookCount === 0) {
    $subtitle = "Pour l'instant aucun livre n'a été enregsitré";
} elseif ($totalBookCount === 1) {
    $subtitle = "Un seul livre";
}
?>
<div class="site-index">

    <div class="jumbotron">

        <h1>Mes Livres</h1>
        <p class="lead">
            <?php if ($totalBookCount === 0) : ?>
                Vous n'avez pour l'instant aucun livre dans votre collection
            <?php elseif ($totalBookCount === 1) : ?>
                Vous n'avez qu'un seul livre dans votre collection
            <?php else : ?>
                Vous avez actuellement <strong><?= $totalBookCount ?></strong> livres dans votre collection
            <?php endif; ?>
        </p>

    </div>
    <?php if(!empty($apiKey)) : ?>
        <div style="display: flex;
        flex-direction: column;
        align-items: center;">
            <div>
                <?= Html::a(
                    'ouvrir l\'application <span class="glyphicon glyphicon-new-window" aria-hidden="true"></span>', 
                    Yii::$app->params['bookAppUrl'] . '/' . $apiKey, 
                    [
                        'class'  => 'btn btn-primary btn-lg', 
                        'target' => 'blank',
                        'title'  => 'ouvrir dans un nouvel onglet'
                    ]
                ) ?>
            </div>
        </div>
    <?php endif ?>
</div>