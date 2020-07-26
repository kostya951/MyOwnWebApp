<?php
use app\models\Task;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;

$query = Task::find()->select([
    'id'
    ,'name'
    ,'description'
    ,'duration'
    ,'completion'
    ,'priority'
    ,'status'
    ,'created'
    ,'last_updated'])->from('task')->orderBy('id');
$dataProvider = new ActiveDataProvider([
    'query' => $query,
    'pagination' => [
        'pageSize' => 20,
    ],
]);
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns'=>[
        'id',
        'name',
        'description',
        'duration',
        'completion',
        'priority',
        'status',
        [
            'attribute' => 'created',
            'format'=>['datetime','dd.MM.Y H:i']
        ],
        [
            'attribute'=>'last_updated',
            'format'=>['datetime','dd.MM.Y H:i']
        ],
        ['class'=>'yii\grid\ActionColumn']
    ]
]);
