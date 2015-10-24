<?php

/* @var $this yii\web\View */
$this->title = 'My Yii Application';

Yii::$app->assetManager->publish("@app/modules/main/assets/img/main_logo.jpg");
$loadingImage = Yii::$app->assetManager->getPublishedUrl("@app/modules/main/assets/img/main_logo.jpg");
?>
<div class="fixed-background">
    <img height="100%" width="100%" src="<?= $loadingImage ?>">
</div>

