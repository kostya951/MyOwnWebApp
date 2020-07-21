<div class="d-lg-flex justify-content-center align-items-center vh-100">
    <div class="w-25">
        <span class="h2">Registration</span>
        <?php
            use yii\widgets\ActiveForm;
            use yii\helpers\Html;

        $form = ActiveForm::begin([
            'options' => [
                'class' => 'form-horizontal'
            ]
        ]);
        ?>
        <div class="form-group">
            <?php echo $form->field($model,'login')->textInput(['class'=> 'form-control', 'id'=>'login']) ?>
        </div>
        <div class="form-group">
            <?php echo $form->field($model,'email')->input('email',['class'=> 'form-control', 'id'=>'email']) ?>
        </div>
        <div class="form-group">
            <?php echo $form->field($model,'password')->passwordInput(['class'=> 'form-control', 'id'=>'password']) ?>
        </div>
        <div class="form-group">
            <?php echo $form->field($model,'submitPassword')->passwordInput(['class'=> 'form-control', 'id'=>'submitPassword']) ?>
        </div>
        <div class="form-group"></div>
        <div class="form-group">
            <div class="row">
                <div class="col-3">
                    <?php echo Html::submitButton('SignUp',['class'=>'btn btn-lg btn-primary']) ?>
                </div>
            </div>
        </div>
        <?php echo $form->errorSummary($model) ?>
    </div>
    <?php ActiveForm::end() ?>
</div>
