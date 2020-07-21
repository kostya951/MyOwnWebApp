<div class="d-lg-flex justify-content-center align-items-center vh-100">
    <div class="w-25">
        <span class="h2">Authorization</span>
        <?php
            use yii\helpers\Html;
            use yii\widgets\ActiveForm;
            use yii\helpers\Url;
            $form = ActiveForm::begin([
                'options' => [
                    'class' => 'form-horizontal'
                ]
            ]);
        ?>
        <div class="form-group">
            <?php echo $form->field($model,'login',)->textInput(['id'=>'login','class'=>'form-control']); ?>
        </div>
        <div class="form-group">
            <?php echo $form->field($model,'password')->passwordInput(['id'=>'password']); ?>
        </div>
        <div class="form-group">
            <div class="row justify-content-between">
                <div class="col-md-auto">
                    <?php echo Html::submitButton('Login',['class'=>'btn btn-lg btn-primary']); ?>
                </div>
                <div class="col-md-auto">
                    <?php echo Html::a('SignUp',Url::to('signup'),['class'=>'btn btn-lg btn-secondary']); ?>
                </div>
            </div>
        </div>
        <?php
            echo Html::errorSummary($model);
            ActiveForm::end();
        ?>
    </div>
</div>

