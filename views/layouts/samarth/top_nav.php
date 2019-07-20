<?php

use app\themes\samarth\assets\SamarthThemeAsset;
use app\models\ApplicationControl;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\widgets\Menu;
$samarthAsset = SamarthThemeAsset::register($this);
?>
<nav class="navbar navbar-expand fixed-top be-top-header">
    <div class="container-fluid">
        <div class="be-navbar-header">
            <a class="navbar-brand" href=""> <span> <?= ApplicationControl::getVariable('app_name') ?> </span></a>
            <a class="be-toggle-left-sidebar" href="#"> <span class="icon mdi mdi-menu"></span></a>
        </div>
        <div class="be-right-navbar">
            <ul class="nav navbar-nav float-right be-user-nav">
                <?php

                if (!Yii::$app->user->isGuest) { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-expanded="false">
                            <img src="<?= $samarthAsset->baseUrl . '/img/avatar.png'; ?>" alt="Avatar">
                            <span class="user-name"><?php echo Yii::$app->user->identity->username; ?></span></a>
                        <div class="dropdown-menu" role="menu">
                            <div class="user-info">
                                <div class="user-name"><?php echo Yii::$app->user->identity->username; ?></div>
                                <div class="user-position online">Available</div>
                            </div>
                            <a href="<?php echo Url::to(['/site/logout']) ?>" data-method="post"
                               class="dropdown-item">
                                <span class="icon mdi mdi-power">
                                </span>
                                Logout
                            </a>
                        </div>
                    </li>
                <?php } ?>
            </ul>
            <div class="page-title">
                <span> <?= ApplicationControl::getVariable('organisation_name') ?></span>
            </div>
        </div>
    </div>
</nav>