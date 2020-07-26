<style>
    .item{
        margin: 10px;
    }
</style>
<div class="row">
    <div class="col-3">
        <div class="row item"><?=$model->getAttributeLabel('id')?>: <?=$model->getAttribute('id')?></div>
        <div class="row item"><?=$model->getAttributeLabel('name')?>: <?=$model->getAttribute('name')?></div>
        <div class="row item"><?=$model->getAttributeLabel('description')?>: <?=$model->getAttribute('description')?></div>
        <div class="row item"><?=$model->getAttributeLabel('priority')?>: <?=$model->getPriority()->getAttribute('name')?></div>
        <div class="row item"><?=$model->getAttributeLabel('duration')?>: <?=$model->getAttribute('duration')?> min</div>
        <div class="row item">
            <a class="btn btn-primary" href="/todo/index/<?=Yii::$app->user->id?>">Назад</a>
        </div>
    </div>
</div>