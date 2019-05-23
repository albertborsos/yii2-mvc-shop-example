<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <h1><?= Yii::t('app', 'Log in with your google account')?></h1>
        <?= yii\authclient\widgets\AuthChoice::widget([
            'baseAuthUrl' => ['/frontend/default/auth'],
            'popupMode' => false,
        ]); ?>
    </div>
</div>
