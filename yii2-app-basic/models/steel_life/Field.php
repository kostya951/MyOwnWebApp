<?php


namespace app\models\steel_life;


class Field
{
    private $rowsAmount=5;
    private $columnsAmount=5;
    public $trigers;
    public $history=[];

    public function __clone(){
        $result = [];
        foreach ($this->trigers as $iRow=>$row){
            foreach ($row as $iCol=>$column){
                $result[$iRow][$iCol] = $column==null?null:clone $column;
            }
        }
        $this->trigers=$result;
    }
    public function  __construct()
    {
        $rows = [];
        for($row=0;$row<$this->rowsAmount;$row++){
            $columns = [];
            for($column=0;$column<$this->columnsAmount;$column++){
                if(
                    ($row==0 && $column==0) ||
                    ($row==1 && $column==2) ||
                    ($row==2 && $column==4) ||
                    ($row==4 && $column==3)
                ){
                    $columns[$column] = null;
                }else {
                    $columns[$column] = new SteelLifeLightTriger($row,$column);
                }
            }
            $rows[$row] = $columns;
        }
        $this->trigers=$rows;

        foreach ($this->trigers as $iRow=>$row){
            foreach ($row as $iColumn=>$column){
                //  устанавливаем текущим тригерам связь с другими тригерами
                if(isset($this->trigers[$iRow][$iColumn+1]) && $this->trigers[$iRow][$iColumn]!=null){
                    $this->trigers[$iRow][$iColumn]->right = $this->trigers[$iRow][$iColumn+1]; //тригер справа
                }

                if(isset($this->trigers[$iRow][$iColumn-1]) && $this->trigers[$iRow][$iColumn]!=null){
                    $this->trigers[$iRow][$iColumn]->left = $this->trigers[$iRow][$iColumn-1]; //тригер слева;
                }

                if(isset($this->trigers[$iRow-1][$iColumn]) && $this->trigers[$iRow][$iColumn]!=null){
                    $this->trigers[$iRow][$iColumn]->up = $this->trigers[$iRow-1][$iColumn];//тригер сверху
                }

                if(isset($this->trigers[$iRow+1][$iColumn]) && $this->trigers[$iRow][$iColumn]!=null){
                    $this->trigers[$iRow][$iColumn]->down = $this->trigers[$iRow+1][$iColumn];//тригер снизу
                }
            }
        }
    }

    public function selectTriger($triger){
        if(!$triger->isActivated()){
            $triger->setActivated();
            $this->history[] = $triger;
            return true;
        }
    }

    public function deselectTriger($triger){
        $triger->setWait();
        array_pop($this->history);
        return true;
    }
    public function unsetWaitTrigers($wait_trigers,$selected_triger){
        foreach ($wait_trigers as $wait_triger){
            if($wait_triger === $selected_triger){
                continue;
            }else{
                $wait_triger->setUnactivated();
            }
        }
    }
    public function setWaitTrigers($triger){
        $result = [];
        $tmp = $triger;
        while(isset($tmp->up) && $tmp->up!=null && !$tmp->up->isActivated()){
            $tmp = $tmp->up;
        }
        if(!($tmp===$triger)){
            $tmp->setWait();
            $result[] = $tmp;
        }

        $tmp = $triger;
        while(isset($tmp->down) && $tmp->down!=null && !$tmp->down->isActivated()){
            $tmp = $tmp->down;
        }
        if(!($tmp===$triger)){
            $tmp->setWait();

            $result[] = $tmp;
        }

        $tmp = $triger;
        while(isset($tmp->right) && $tmp->right!=null && !$tmp->right->isActivated()){
            $tmp = $tmp->right;
        }
        if(!($tmp===$triger)){
            $tmp->setWait();
            $result[] = $tmp;
        }

        $tmp = $triger;
        while(isset($tmp->left) && $tmp->left!=null && !$tmp->left->isActivated()){
            $tmp = $tmp->left;
        }
        if(!($tmp===$triger)){
            $tmp->setWait();
            $result[] = $tmp;
        }
        return $result;
    }

    public function reset(){
        $this->history=[];
        foreach ($this->trigers as $row){
            foreach ($row as $column){
                if($column!=null) {
                    $column->setUnactivated();
                }
            }
        }
    }

    public function recursiveTrigers($field,$trigers,$last_triger){
        foreach ($trigers as $triger){
            if($field->selectTriger($triger)){
                $field->activateLine($last_triger,$triger);
                $wait_trigers = $field->setWaitTrigers($triger);
                if(count($wait_trigers)==0){
                    if($field->isAllActivated()){
                        return $field->history;
                    }else{
                        return null;
                    }
                }
                //$tmp= clone $field;
                $answer = $field->recursiveTrigers($field,$wait_trigers,$triger);
                if($answer!=null){
                    return $answer;
                }
                //$field->unsetWaitTrigers($wait_trigers,$triger);
                $field->deactivateLine($last_triger,$triger);
                $field->deselectTriger($triger);
            }
        }
    }

    public function isAllActivated(){
        foreach ($this->trigers as $row){
            foreach ($row as $column){
                if($column!=null && $column->isUnactivated()){
                    return false;
                }
            }
        }
        return true;
    }

    public function activateLine($last_triger,$selected_triger){
        $counter = 0;
        if($last_triger->row==$selected_triger->row){
            if($last_triger->column > $selected_triger->column){
                while(isset($last_triger->left) && $last_triger->left!=null && !$last_triger->left->isActivated()){
                    $counter++;
                    $last_triger = $last_triger->left;
                    $last_triger->setActivated();
                }
                return $counter>0;
            }else{
                while(isset($last_triger->right) && $last_triger->right!=null && !$last_triger->right->isActivated()){
                    $counter++;
                    $last_triger = $last_triger->right;
                    $last_triger->setActivated();
                }
                return $counter>0;
            }
        }else{
            if($last_triger->row > $selected_triger->row){
                while(isset($last_triger->up) && $last_triger->up!=null && !$last_triger->up->isActivated()){
                    $counter++;
                    $last_triger = $last_triger->up;
                    $last_triger->setActivated();
                }
                return $counter>0;
            }else{
                while(isset($last_triger->down) && $last_triger->down!=null && !$last_triger->down->isActivated()){
                    $counter++;
                    $last_triger = $last_triger->down;
                    $last_triger->setActivated();
                }
                return $counter>0;
            }
        }
    }

    public function deactivateLine($last_triger,$selected_triger){
        $counter = 0;
        if($last_triger->row==$selected_triger->row){
            if($last_triger->column > $selected_triger->column){
                while(isset($last_triger->left) && $last_triger->left!=null && $last_triger->left->isActivated()){
                    $counter++;
                    $last_triger = $last_triger->left;
                    $last_triger->setUnactivated();
                }
                return $counter>0;
            }else{
                while(isset($last_triger->right) && $last_triger->right!=null && $last_triger->right->isActivated()){
                    $counter++;
                    $last_triger = $last_triger->right;
                    $last_triger->setUnactivated();
                }
                return $counter>0;
            }
        }else{
            if($last_triger->row > $selected_triger->row){
                while(isset($last_triger->up) && $last_triger->up!=null && $last_triger->up->isActivated()){
                    $counter++;
                    $last_triger = $last_triger->up;
                    $last_triger->setUnactivated();
                }
                return $counter>0;
            }else{
                while(isset($last_triger->down) && $last_triger->down!=null && $last_triger->down->isActivated()){
                    $counter++;
                    $last_triger = $last_triger->down;
                    $last_triger->setUnactivated();
                }
                return $counter>0;
            }
        }
    }
}