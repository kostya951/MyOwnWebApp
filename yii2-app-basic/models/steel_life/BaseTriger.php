<?php


namespace app\models\steel_life;


class BaseTriger
{
    protected $states;
    protected $current_state;

    public function changeState($state){
        $this->current_state=$state;
    }

    public function setStates($states){
        $this->states=$states;
    }
}