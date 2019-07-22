<?php
/**
 * Created by PhpStorm.
 * User: iic
 * Date: 20/07/19
 * Time: 2:02 PM
 */
use yii\widgets\ActiveForm;
use app\modules\demomodule\models\AdministrativeUnit;
use app\modules\demomodule\models\Designation;
$this->title = Yii::t('app', 'Dependent Dropdown');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card">
    <div class="card-header"><h3>This is dependent dropdown</h3></div>
    <div class="card-body">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'id' => 'dependent-form']); ?>
        <div class="col-md-6">
            <?=
            $form->field($model, 'department')->dropDownList(AdministrativeUnit::getActiveOu(), [
                'prompt' => Yii::t('app', 'Select'),
                'onchange' => '
                    $.post( "' . Yii::$app->urlManager->createUrl('demomodule/app/list-designations?id=') .
                    '"+$(this).val(), function( data ) {
                      $( "select#dependent-designation" ).html( data );
                    });'
            ])
            ?></div>
        <div class="col-md-6"><?php
            echo $form->field($model, 'designation')->dropDownList([$model->designation => Designation::resolveById($model->designation)], ['prompt' => Yii::t('app', 'Select')]);

            ?></div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<pre>
     echo $form->field($model, 'department')->dropDownList(AdministrativeUnit::getActiveOu(), [
        'prompt' => Yii::t('app', 'Select'),
        'onchange' => '
                    $.post( "' . Yii::$app->urlManager->createUrl('demomodule/app/list-designations?id=') .
            '"+$(this).val(), function( data ) {
                      $( "select#dependent-designation" ).html( data );
                    });'
    ]);

    echo $form->field($model, 'designation')->dropDownList([$model->designation => Designation::resolveById($model->designation)], ['prompt' => Yii::t('app', 'Select')]);

    Action
    
     public function actionListDesignations($id)
    {
        $models = CoreOuStructure::getDesignationsByOu($id);
        if (!empty($models)) {
            foreach ($models as $key => $model) {
                echo < option value=' . $key . '> . $model . < /option>;
            }
        } else {
            echo "< option value='0'>Self< /option>";
        }
    }


</pre>
