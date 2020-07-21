<?php


namespace app\models\steel_life;


class SteelLifeLightTriger extends BaseTriger
{
    public $row;
    public $column;

    public $up;
    public $right;
    public $left;
    public $down;

    public function  __construct($row,$column)
    {
        $this->row=$row;
        $this->column=$column;
        $this->setStates(['UNACTIVATED','ACTIVATED','WAIT']);
        $this->current_state='UNACTIVATED';
    }

    public function __clone(){
        $this->up = $this->up==null?null:clone $this->up;
        $this->right = $this->right==null?null:clone $this->right;
        $this->left = $this->left==null?null:clone  $this->left;
        $this->down = $this->left==null?null:clone $this->down;
    }

    public function setUnactivated(){
        $this->changeState($this->states[0]);
    }

    public function setActivated(){
        $this->changeState($this->states[1]);
    }

    public function setWait(){
        $this->changeState($this->states[2]);
    }

    public function isUnactivated(){
        return $this->current_state==$this->states[0];
    }

    public function isActivated(){
        return $this->current_state==$this->states[1];
    }

    public function isWait(){
        return $this->current_state==$this->states[2];
    }

}