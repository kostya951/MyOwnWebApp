<div class="d-lg-flex justify-content-center align-items-center vh-100">
    <div class="w-25">
        <?php
            use yii\widgets\ActiveForm;
            use yii\helpers\Html;
            use yii\helpers\Url;
            $form = ActiveForm::begin();

            echo $form->field($model,'id')->textInput(['id'=>'id','disabled'=>true]);
            //echo $form->field($model,'PARENT')->dropDownList([],['class'=>'form-control']);
            echo $form->field($model,'parent')->textInput(['id'=>'parent','class'=>'form-control']);
            echo $form->field($model,'name')->textInput(['id'=>'name','class'=>'form-control']);
            echo $form->field($model,'description')->textarea(['id'=>'description','class'=>'form-control']);
            echo $form->field($model,'priority')->dropDownList([
                '1'=>'Lowest',
                '2'=>'Low',
                '3'=>'Normal',
                '4'=>'High',
                '5'=>'Highest'
            ],[
                'class'=>'form-control',
                'options'=>[
                    '3'=>['selected'=>true]
                ]
            ]);
            echo $form->field($model,'duration')->textInput(['id'=>'duration','class'=>'form-control']);
            $id = $model->getAttribute('id');
            if(!isset($id)){
                echo Html::submitButton('Create',['class'=>'btn btn-lg btn-primary']);
            }else{
                echo Html::a('To list',Url::toRoute('todo/index/'.Yii::$app->user->id),['class'=>'btn btn-lg btn-primary']);
            }
            echo $form->errorSummary($model);

            ActiveForm::end()
        ?>
    </div>
</div>


