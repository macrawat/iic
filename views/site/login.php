<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Sign In';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="splash-container">
    <div class="card card-border-color card-border-color-primary">
        <div class="card-header">
            <!--            <img class="logo-img" src="assets/img/logo-xx.png" alt="logo" width="102" height="27">-->
            <h4 class="mt-0"><?php echo $this->title; ?></h4>
            <span class="splash-description">Please enter your user information.</span>
        </div>
        <div class="card-body">
            <?php
            $form = ActiveForm::begin(['id' => 'login-form',]);
            ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => 'Registered Email']) ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'rememberMe')->checkbox([]) ?>
            <div class="form-group">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <!--    <div class="splash-footer"><span>Don't have an account? --><?//= Html::a('Sign Up', ['/registration/adm/signup']) ?><!--</a></span>-->
    <!--        <br/>-->
    <!--        --><?//= Html::a('Reset Password', ['/login/adm/request-password-reset']) ?><!-- <br/>-->
    <!--        --><?//= Html::a('Help', ['/site/about']) ?><!--</div>-->
</div>