<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\demomodule\models\Demo */

$this->title = Yii::t('app', 'Create Demo');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Demos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="demo-create">

    <div class="card">
        <div class="card-header"><h3>This Form Heading /Title</h3></div>
        <div class="card-body">
        <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
        </div>
    </div>

</div>
