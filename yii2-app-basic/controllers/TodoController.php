<?php
namespace app\controllers;
use app\models\Task;
use app\models\TodoUser;
use yii\helpers\Url;
use yii\web\Controller;
use Yii;

class TodoController extends Controller{

    public function actionIndex($id){
        if(Yii::$app->user->isGuest){
            $this->redirect(Url::toRoute('default/login'));
        }
        $this->layout= 'todo';
        return $this->render('list',['user'=>$id]);
    }
    public function actionDelete(){
        $model = Task::find()->where(['id'=>Yii::$app->request->get('id')])->one();
        $model->delete();
        $this->redirect(Url::toRoute("todo/index/".Yii::$app->user->id));
    }
    public function actionCreate(){
        if(Yii::$app->user->isGuest){
            $this->redirect(Url::toRoute('default/login'));
        }
        $model = new Task();
        if($model->load(Yii::$app->request->post())){
            $user = TodoUser::findOne(['id'=>Yii::$app->user->id]);
            $model->setAttribute('user', $user->id);
            $parent = $model->getAttribute('parent');
            $_parent = null;
            if($model->validate())
            {
                if(!empty($parent)){
                    $_parent = Task::findOne(['id'=>$model->getAttribute("parent")]);
                    if(isset($_parent)) {
                        $model->setAttribute('parent', $_parent->getAttribute('id'));
                        if($model->save()) {
                            return $this->render('create', ['model' => $model]);
                        }
                    }else{
                        $model->addError(null, 'Parent Task not found');
                    }
                }else{
                    $sql=<<<sql
SELECT PARAMETER,VALUE FROM NLS_SESSION_PARAMETERS
sql;

                    $query = Yii::$app->getDb()->createCommand($sql)->queryAll();
                    if($model->save()) {
                        return $this->render('create', ['model' => $model]);
                    }
                }
            }
        }
        return $this->render('create',['model'=>$model]);
    }
}
