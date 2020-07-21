<?php
namespace app\models;
use Yii;
use yii\base\ExitException;

class LoginForm extends \yii\base\Model{
    public $login;
    public $password;

    private $_user = false;
    public function rules()
    {
        return [
            [['login','password'],'required'],
            ['password','validatePassword']
        ];
    }

    public function attributeLabels()
    {
        return [
            'login'=>'Login',
            'password'=>'Password'
        ];
    }

    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser());
        }
        return false;
    }

    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = TodoUser::findByLogin($this->login);
        }
        return $this->_user;
    }

    public function validatePassword(){
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError(null, 'Incorrect username or password.');
            }
        }
    }
}
