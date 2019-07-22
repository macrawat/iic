<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\demomodule\models\Demo;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\demomodule\models\search\DemoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Demos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="demo-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Demo'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'middle_name',
            'mobile',
            'email:email',
            [
                'attribute' => 'city',
                'value' => function ($data) {
                    return Demo::resolveCity($data->city);
                },
                'filter' => Html::activeDropDownList($searchModel, 'city', Demo::getCity(),
                    ['prompt' => "All",
                        'class' => 'form form-control',
                    ]
                ),
            ],
            //'city',
            //'other_city',
            //'status',
            //'created_at',
            //'updated_at',
            //'created_by',
            //'updated_by',
            //'ip',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}',
                'buttons' => [
                    'view' => function ($data, $model) {
                        return Html::a('<span><i class="mdi mdi-eye"></i></span>',
                            ["view", 'id' => $model->id],
                            ['class' => 'btn-secondary', 'title' => 'View']);
                    },
                    'update' => function ($data, $model) {
                        return Html::a('<span><i class="mdi mdi-edit"></i></span>',
                            ["update", 'id' => $model->id],
                            ['class' => 'btn-secondary', 'title' => 'Update']);
                    },
                ],
            ],
        ],
    ]); ?>


</div>
