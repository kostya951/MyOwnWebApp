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

    public function actionView(){
        $model = Task::find()->where(['id'=>Yii::$app->request->get('id')])->one();
        $this->layout='todo';
        $priority = $model->getPriority();
        return $this->render('view',['model'=>$model]);
    }

    public function actionUpdate(){
        if(Yii::$app->request->getIsGet()) {
            $model = Task::find()->where(['id' => Yii::$app->request->get('id')])->one();
            return $this->render('create',['model'=>$model,'update'=>true]);
        }else if(Yii::$app->request->getIsPost()){
            $form = Yii::$app->request->post();
            $model = Task::findOne(['id'=>$form['Task']['id']]);
            $model->load($form);
            unset($model->id);
            if($model->save()){
                $this->redirect(Url::toRoute("todo/index/".Yii::$app->user->id));
            }
        }
    }

    public function actionCreate(){
        if(Yii::$app->user->isGuest){
            $this->redirect(Url::toRoute('default/login'));
        }
        $model = new Task();
        if($model->load(Yii::$app->request->post())){
            $user = TodoUser::findOne(['id'=>Yii::$app->user->id]);
            $model->setAttribute('user', $user->id);
            if($model->validate())
            {
                if($model->save()) {
                    return $this->render('create', ['model' => $model,'update'=>false]);
                }
            }
        }
        return $this->render('create',['model'=>$model,'update'=>false]);
    }
}
