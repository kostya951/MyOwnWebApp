<?php
use app\models\Task;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;

$query = Task::find()->select(['name'
    ,'parent'
    ,'duration'
    ,'completion'
    ,'priority'
    ,'status'
    ,"CONVERT(DATETIME,\"CREATED\",104)"
    ,"CONVERT(DATETIME,\"LAST_UPDATED\",104)"])->from('task')->orderBy("id");
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
        'parent',
        'description',
        'duration',
        'completion',
        'priority',
        'status',
        [
            'attribute' => 'created:datetime',
            'format'=>['datetime','dd.MM.Y H:i']
        ],
        'last_updated:datetime',
        ['class'=>'yii\grid\ActionColumn']
    ]
]);
