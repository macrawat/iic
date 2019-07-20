<?php
/* @var $this \yii\web\View */

/* @var $content string */

use app\themes\samarth\assets\SamarthThemeAsset;
use app\models\ApplicationControl;
use app\models\Employee;
use app\modules\master\models\Session;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\widgets\Menu;

$samarthAsset = SamarthThemeAsset::register($this);

$this->title = ApplicationControl::getVariable('app_name');
?>
<?php $home = Yii::$app->request->BaseUrl; ?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <?= Html::csrfMetaTags() ?>
        <title>
            <?= Html::encode($this->title) ?>
        </title>
        <?php $this->head() ?>
    </head>
    <body class="be-splash-screen">
    <?php $this->beginBody() ?>

    <div class="be-wrapper be-login">
        <div class="be-content">
            <div class="main-content container-fluid">

                <?= $this->render('alerts') ?>

                <?= $content ?>

            </div>
        </div>
    </div>
    <?php if (Yii::$app->session->get('year') == NULL || Yii::$app->session->get('month') == NULL) { ?>
        <input style="display:none" id="sessionData" value="1">
    <?php } else { ?>
        <input style="display:none" id="sessionData" value="2">
    <?php } ?>

    <!-- END wrapper -->

    <?php $this->endBody() ?>
    <?php
    $this->registerJs(<<<JS
      $(document).ready(function(){
      	//-initialize the javascript
      	App.init();
      });
JS
    )
    ?>
    </body>
    </html>
<?php $this->endPage() ?>
<?php
