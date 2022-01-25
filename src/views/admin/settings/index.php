<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'Settings';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-index">

    <h1>
        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
        <?= Html::encode($this->title) ?>
    </h1>
    <hr />



    <table class="table table-striped table-hover ">
      <thead>
        <tr>
          <th>Param. Name</th>
          <th>value</th>
          <th>Descr.</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th scope="row">@qrcodeUrl</th>
          <td><?= Yii::getAlias('@qrcodeUrl') ?></td>
          <td></td>
        </tr>
        <tr>
          <th scope="row">@qrcodePath</th>
          <td><?= Yii::getAlias('@qrcodePath') ?></td>
          <td></td>
        </tr>
        <tr>
          <th scope="row">saveBookPing</th>
          <td><?= Yii::$app->params['saveBookPing'] ? 'true' : 'false'?></td>
          <td></td>
        </tr>
        <tr>
          <th scope="row">enableAccountActivation</th>
          <td><?= Yii::$app->params['enableAccountActivation'] ? 'true' : 'false'?></td>
          <td></td>
        </tr>
        <tr>
          <th scope="row">enableVerifyCodeOnLogin</th>
          <td><?= Yii::$app->params['enableVerifyCodeOnLogin'] ? 'true' : 'false'?></td>
          <td>Captcha on/off</td>
        </tr>
        <tr>
          <th scope="row">enableVerifyCodeOnCreateAccount</th>
          <td><?= Yii::$app->params['enableVerifyCodeOnCreateAccount'] ? 'true' : 'false'?></td>
          <td>Captcha on/off</td>
        </tr>
        <tr>
          <th scope="row">bookAppUrl</th>
          <td><?= Html::a(Yii::$app->params['bookAppUrl'],Yii::$app->params['bookAppUrl'], ['target' => '_blank'])?></td>
          <td></td>
        </tr>
        <tr>
          <th scope="row">qrcodeUrl</th>
          <td><?= Html::a(Yii::$app->params['qrcodeUrl'],Yii::$app->params['qrcodeUrl'], ['target' => '_blank'])?></td>
          <td></td>
        </tr>
        <tr>
          <th scope="row">checkpointUrl</th>
          <td><?= Html::a(Yii::$app->params['checkpointUrl'],Yii::$app->params['checkpointUrl'], ['target' => '_blank'])?></td>
          <td></td>
        </tr>
      </tbody>
    </table>

</div>