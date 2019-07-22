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
$this->title = Yii::t('app', 'CRUD Form Template');
$this->params['breadcrumbs'][] = $this->title;
?>
<h3>Model Validation</h3>
<pre>

    <strong>//Unique Attribute</strong>
    [['user_id', 'leaveId', 'fromDate','status'],'unique','targetAttribute' => ['user_id', 'leaveId', 'fromDate','status'], 'message' => 'Already applied '],

    <strong>//Mobile Validation Regex</strong>
    [['mobile', 'guardianMobile', 'motherMobile'], 'match', 'pattern' => '/^[6789]\d{9}$/'],

    <strong>//Required Conditional</strong>
    [['otherNationality'], 'required', 'when' => function ($model) {
                return $model->nationality == 2;
            }, 'whenClient' => "function (attribute, value) {
                       return $('#jibvocuserpersonal-nationality').val() == 2;
                   }", 'message' => '{attribute} cannot be blank'],
            

</pre>
<h3>Form Template</h3>
<pre>
    &lt;div class="card"&gt;
        &lt;div class="card-header"&gt;&lt; h3&gt;This Form Heading /Title&lt;/h3&gt;&lt;/div&gt;
        &lt;div class="card-body"&gt;
         &lt;?php   $form = ActiveForm::begin(['fieldConfig' => [
            'template' => "&lt;div class='col-sm-3'&gt;{label}&lt;/ div&gt;&lt;div class='col-sm-9'&gt;{input}\n{hint}\n{error}&lt;/div&gt;",
            'options' => ['class' => 'row'],
            ],
            ]); ?&gt;


            //Form Elelements Here

    &lt;?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Add') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success float-right' : 'btn btn-primary float-right']) ?&gt;
           &lt;?php ActiveForm::end() ?&gt;
        &lt;/div&gt;
    &lt;/div&gt;

</pre>

<h3>Form JS Template</h3>
<pre>
&lt;?php
$this->registerJs(<<&lt;JS
$('#jibvocuserpersonal-nationality').on('change', function(){
   if($(this).val() == 2){
       $('#other_nationality').show();
       $('#religion').hide();        
   }else{
       $('#religion').show(); 
       $('#other_nationality').hide();
   }
});
$('#jibvocuserpersonal-nationality').trigger('change');

JS
);

</pre>



<h3>Filter in Grid View</h3>
<pre>
    [
                'attribute' => 'annual',
                'label'=>'Annual',
                'format' => 'html',
                'value' => function ($data) {
                    return StatusHelper::resolveYesNo($data->annual);
                },
                'filter' => Html::activeDropDownList($searchModel, 'annual', StatusHelper::getYesNo(),
                    ['prompt' => "All",
                        'class' => 'form form-control',
                    ]
                ),
            ],
</pre>




<h3>Action Column in Gridview</h3>
<pre>
     [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{view}{update}{organigram}',
                            'buttons' => [
                                'view' => function ($data, $model) {
                                    return Html::a('&lt;span&gt;&lt;i class="icons mdi mdi-eye"&gt;&lt;/i&gt;&lt;/span&gt;',
                                        ["view", 'id' => $model->id],
                                        ['class' => 'btn btn-secondary', 'title' => 'View']);
                                },
                                'update' => function ($data, $model) {
                                    return Html::a('&lt;span&gt;&lt;i class="icons mdi mdi-edit"&gt;&lt;/i&gt;&lt;/span&gt;',
                                        ["update", 'id' => $model->id],
                                        ['class' => 'btn btn-secondary', 'title' => 'Update']);
                                },
                                
                            ],
                        ],

</pre>




