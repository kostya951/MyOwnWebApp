<?php


namespace app\controllers;


use app\models\steel_life\Field;
use Yii;
use yii\web\controller;

class LifeController extends Controller{

    public function actionIndex(){
        if(Yii::$app->params['lifeEnabled']) {
            $field = new Field();
            $trigers = $field->trigers;
            $answer = null;
            for ($row = 0; $row < count($trigers); $row++) {
                for ($column = 0; $column < count($trigers[$row]); $column++) {
                    $triger = $trigers[$row][$column];
                    if ($triger != null && $field->selectTriger($triger)) {
                        $wait_trigers = $field->setWaitTrigers($triger);
                        //$tmp = clone $field;
                        $answer = $field->recursiveTrigers($field, $wait_trigers, $triger);
                        if ($answer != null) {
                            break;
                        }
                    }
                    $field->reset();
                }
                if ($answer != null) {
                    break;
                }
            }

            if ($answer != null) {
                echo "<pre>";
                foreach ($answer as $i => $history) {
                    $row = $history->row;
                    $column = $history->column;
                    echo "<div>{$i} row={$row} col={$column}</div>";
                }
            }
        }
    }
}