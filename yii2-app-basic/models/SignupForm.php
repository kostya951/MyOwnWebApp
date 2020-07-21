<?php
namespace  app\models;
use yii\base\ExitException;

class SignupForm extends \yii\base\Model{
    public $login;
    public $password;
    public $submitPassword;
    public $email;

    public function rules()
    {
        return [
            [['login','password','submitPassword','email'],'required','message'=>'{attribute} are required'],
            ['email','email','message'=>'Invalid email'],
            [['login', 'email'], 'string', 'max' => 100,'message'=>'Login or email max 100 characters'],
            ['password', 'string', 'max' => 255,'message'=>'Password max 255 characters'],
            ['submitPassword','compare','compareAttribute'=>'password','message'=>'Passwords does not match']
        ];
    }

    public function attributeLabels()
    {
        return [
            'login'=>'Login',
            'password'=>'Password',
            'submitPassword'=>'Submit your password',
            'email'=>'Email'
        ];
    }

    public function validateNewUser(){
        $user = TodoUser::findByLogin($this->login);
        if(isset($user)) {
            return false;
        }
        return true;
    }
}
