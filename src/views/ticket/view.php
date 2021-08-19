<?php

use yii\helpers\Html;
/* @var $this yii\web\View */
?>
<div>
    <h1>Ticket</h1>
    <hr />
    <div class="grid">
        <div class="row">
            <div class="col-sm-6">
                <h2>
                    <?= Html::encode($book->title) ?>
                    <?php if (!empty($book->subtitle)) : ?>
                        <br /><small>
                            <?= Html::encode($book->subtitle) ?>
                        </small>
                    <?php endif; ?>
                </h2>
                <p>Author name here</p>
                <hr />
                <h4 class="hidden-print" style="text-align: center;color: gray;">Code Passager</h4>
                <div style="font-size: 1.6em;
padding: 0.3em;
text-align: center;
border: 1px solid;">
                    6X4-HTE-B
                </div>

            </div>
            <div class="col-sm-6" style="text-align: center;">
                <img src="<?= $qrCode->writeDataUri() ?>" title="QR code" alt="QR code" />
            </div>
            <div class="col-sm-12">
                <h4 class="hidden-print" style="text-align: center;color: gray;">Checkpoint</h4>
                <div style="font-size: 1.6em;
padding: 0.3em;
text-align: center;
border: 1px solid;">
                    https://my-books.mariola.fr/ping
                </div>
                <hr />
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <p>Instructions</p>
                <p>Pour préparer votre livre au voyage, vous avez 2 options:</p>
                <ol>
                    <li><strong>Recopier le code passager et le checkpoint sur une page du livre</strong>. Par exemple au dos de la couverture, sur la page intérieure de titre ou encore parmi les dernières pages</li>
                    <li><strong>imprimer et coller le QR Code</strong>.</li>
                </ol>
            </div>
            <div class="col-sm-6">
                <p><strong>ATTENTION</strong> Si les informations du ticket de voyage ne sont pas correctement recopiées ou si le qr-code se décolle,
                le prochain lecteur n'aura pas la possibilité de signaler que le livre est arrivé entre ses mains. </p>
            </div>
        </div>
    </div>
</div>