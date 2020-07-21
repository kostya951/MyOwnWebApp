<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "TODO_USER".
 *
 * @property float $id
 * @property string $login
 * @property string $password
 * @property string|null $email
 */
class TodoUser extends \yii\db\ActiveRecord implements IdentityInterface
{
    public $authKey;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'todo_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'number'],
            [['login', 'password'], 'required'],
            [['login', 'email'], 'string', 'max' => 100],
            [['password'], 'string', 'max' => 255],
            [['id','login'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Login',
            'password' => 'Password',
            'email' => 'Email',
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    public static function findByLogin($login)
    {
        $user = self::findOne(['login'=>$login]);
        if(isset($user)) {
            if ($user->attributes['login'] === $login) {
                return new static($user);
            }
        }
        return null;
    }

    public function validatePassword($password){
        return $this->getAttribute('password')===$password;

    }
}
