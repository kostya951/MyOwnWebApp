<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use app\assets\TodoAssets;
use \yii\helpers\Url;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;

TodoAssets::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<header class="row">
    <div class="col-10"></div>
    <div class="col-2 text-lg-right">
        <?php echo Html::a('Logout',Url::toRoute('default/logout'),['class'=> 'btn btn-sm btn-primary'
            ,'style'=>'margin-right:10px;'])?>
    </div>
</header>
<div class="container-fluid">
    <div class="row">
        <div class="col-2">
            <?php
                NavBar::begin([
                    'options'=>[
                        'class'=>'navbar-light'
                    ]
                ]);
                echo Nav::widget([
                    'options'=>[
                        'class'=>'nav nav-pills navbar-right'
                    ],
                    'items'=> [
                        ['label'=>'Create new TODO','url'=>['todo/create']],
                        ['label'=>'SteelLife','url'=>['life/index']]
                    ]
                ]);
                NavBar::end();
            ?>
        </div>
        <div class="col-10">
            <?= $content ?>
        </div>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>


