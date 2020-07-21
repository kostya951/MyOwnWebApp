<?php
namespace app\controllers;
use app\models\TodoUser;
use app\dka\DKA;
use app\dka\State;
use Yii;
use app\models\LoginForm;
use app\models\SignupForm;
use yii\helpers\Url;
use yii\web\Controller;

class DefaultController extends Controller{

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex(){
        if(Yii::$app->user->isGuest) {
            $this->redirect(Url::to('default/login'));
        }else{
            $this->redirect(Url::toRoute('todo/index/'.Yii::$app->user->id));
        }
    }

    public function actionLogin(){
        if(!Yii::$app->user->isGuest){
            $this->redirect(Url::toRoute(['todo/index/'.Yii::$app->user->id]));
        }
        $model = new LoginForm();
        if($model->load(Yii::$app->request->post())){
            if($model->login()) {
                $this->redirect(Url::toRoute(['todo/index/' . Yii::$app->user->id]));
            }
        }
        return $this->render('login',['model'=>$model]);
    }


    public function actionSignup(){
        if(!Yii::$app->user->isGuest){
            $this->redirect(Url::toRoute('todo/index'));
        }
        $model = new SignupForm();
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            if(!$model->validateNewUser()){
                $model->addError('login','Login already exists');
            }else{
                $user = new TodoUser();
                $user->login = $model->login;
                $user->email = $model->email;
                $user->password = $model->password;
                if($user->save()){
                    $form = new LoginForm();
                    $form->password=$user->password;
                    $form->login=$user->login;
                    $this->redirect(Url::toRoute('default/login'));
                }else{
                    $model->addError(null,$user->errors);
                }
            }
        }
        return $this->render('signup',['model'=>$model]);
    }

    public function actionLogout(){
        Yii::$app->user->logout();
        $this->redirect(Url::toRoute('default/login'));
    }
    public function actionException()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->renderPartial('error', ['exception' => $exception]);
        }
    }
}


