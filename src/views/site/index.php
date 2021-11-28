<?php

use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */

$this->title = 'Mes Livres';
?>
<div class="site-index">
  <div class="jumbotron">
    <h1>Mes Livres</h1>
    <p class="lead">Gérez votre collection de livres<br/>Faites les voyager</p>
  </div>
  
  <div class="row">

    <div class="col-lg-4">
      <div class="main-3cols">
        <div class="home-image col-item" style="background-image: url('<?= Url::to('images/book-list-2.png') ?>');"></div>
        <div class="col-item">
          <h2>Votre Collection</h2>
          <p>
            Regroupez tous vos livres à un seul endroit. Retrouvez-les facilement avec
            le filtre de recherche sur le titre ou le nom d'auteur. Vous pourrez à tout moment rajouter
            de nouveaux livres à votre collection, ou bien annoter ceux qui s'y trouvent déjà.
          </p>
        </div>
      </div>
    </div><!-- /.col-lg-4 -->

    <div class="col-lg-4">
      <div class="main-3cols">
        <div class="home-image col-item" style="background-image: url('<?= Url::to('images/book-detail-2.png') ?>');">
        </div>
        <div class="col-item">
          <h2>En Détail</h2>
          <p>
            Affichez les détails d'un livre comme par exemple la note que vous lui aviez donné. Si vous avez
            renseigné le numéro ISBN lors de l'ajout du livre, son résumé est accessible à la demande.
          </p>
        </div>
      </div>
    </div><!-- /.col-lg-4 -->

    <div class="col-lg-4">
      <div class="main-3cols">
        <div class="home-image col-item" style="background-image: url('<?= Url::to('images/book-ticket.png') ?>');">
        </div>
        <div class="col-item">
          <h2>Livre Voyageur</h2>
          <p>
            Pour les livres que vous ne voulez pas relire, le <em>voyage</em> est une bonne solution. Créez un ticket,
            collez-le au dos de la couverture et votre livre et prêt à embarquer. Vous pourrez suivre sont voyage si
            son prochain lecteur le signale.
          </p>
        </div>
      </div>
    </div><!-- /.col-lg-4 -->

  </div>
</div>