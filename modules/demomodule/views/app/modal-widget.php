<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\helpers\Html;
$this->title = Yii::t('app', 'Modal Widget');
$this->params['breadcrumbs'][] = $this->title;




?>

<h3>Modal Widget Usage <?= Html::a('Download Manual',['http://10.107.107.107/uploads/uims/PU-1736838-190719-1430-32.pdf'],['target' => '_blank','class' =>'btn btn-secondary']) ?></h3>
<pre>
&lt;?php echo ModalWidget::widget([
                                    'options' => [
                                        'mode' => ModalWidget::UPDATE,
                                        'name' => Yii::t('app', 'Forward RTI'),
                                        'buttonClass' => 'btn btn-success',
                                        'form_path' => Url::to(['/rti/forwarded/create-modal', 'rtiNumber' => SecurityHelper::hashData($model->rtiNumber)]),
                                        //  'view_path' => Url::to(['index-role']), //This is removed because it is in update mode and we do not need the view from widget
                                        'page_reload' => true
                                    ]
                                ]);
?&gt;

</pre>