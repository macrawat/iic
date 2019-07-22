<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\demomodule\models\Demo;

/* @var $this yii\web\View */
/* @var $model app\modules\demomodule\models\Demo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="demo-form">

    <?php $form = ActiveForm::begin(['fieldConfig' => [
        'template' => "<div class='col-sm-3'>{label}</div><div class='col-sm-9'>{input}\n{hint}\n{error}</div>",
        'options' => ['class' => 'row form-group'],
    ],
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'city')->dropDownList(Demo::getCity(),['prompt' => 'Select']) ?>

    <div id="other_city">
        <?= $form->field($model, 'other_city')->textInput(['maxlength' => true]) ?>
    </div>

    <?= $form->field($model, 'status')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success float-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$this->registerJs(<<<JS
$('#demo-city').on('change', function(){
   if($(this).val() == 2){
       $('#other_city').show();     
   }else{ 
       $('#other_city').hide();
   }
});
$('#demo-city').trigger('change');

JS
);
