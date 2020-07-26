<div class="d-lg-flex justify-content-center align-items-center">
    <div class="w-25">
        <?php
            use yii\widgets\ActiveForm;
            use yii\helpers\Html;
            use yii\helpers\Url;
            $form = ActiveForm::begin();
            $disabled = $update ? 'disabled' : '';
            echo $form->field($model,'id')->textInput(['id'=>'id','disabled'=>true]);
            echo $form->field($model,'name')->textInput(['id'=>'name','class'=>'form-control']);
            echo $form->field($model,'description')->textarea(['id'=>'description','class'=>'form-control']);
            echo $form->field($model,'completion')->dropDownList([
                '0'=>'0%',
                '10'=>'10%',
                '20'=>'20%',
                '30'=>'30%',
                '40'=>'40%',
                '50'=>'50%',
                '60'=>'60%',
                '70'=>'70%',
                '80'=>'80%',
                '90'=>'90%',
                '100'=>'100%',
            ],[
                'class'=>'form-control',
                $disabled,
                'options'=>[
                    $model->getAttribute('completion')=>['selected'=>true]
                ]
            ]);
            $priority = $model->getAttribute('priority');
            echo $form->field($model,'priority')->dropDownList([
                '1'=>'Lowest',
                '2'=>'Low',
                '3'=>'Normal',
                '4'=>'High',
                '5'=>'Highest'
            ],[
                'class'=>'form-control',
                $disabled,
                'options'=>[
                    isset($priority)?$priority:'3'=>['selected'=>true]
                ]
            ]);
            $status = $model->getAttribute('status');
            echo $form->field($model,'status')->dropDownList([
                    '0'=>'Undone',
                    '1'=>'Done'
            ],[
                'class'=>'form-control',
                $disabled,
                'options'=>[
                        isset($status)?$status:'0'=>['selected'=>true]
                ]
            ]);
            echo $form->field($model,'duration')->textInput(['id'=>'duration','class'=>'form-control']);
            $id = $model->getAttribute('id');
            if(!isset($id) && !$update){
                echo Html::submitButton('Create',['class'=>'btn btn-lg btn-primary']);
            }else if(!isset($id) && $update){
                echo Html::submitButton('Update',['class'=>'btn btn-lg btn-primary']);
            }else{
                echo Html::a('To list',Url::toRoute('todo/index/'.Yii::$app->user->id),['class'=>'btn btn-lg btn-primary']);
            }
            echo $form->errorSummary($model);

            ActiveForm::end()
        ?>
    </div>
</div>


