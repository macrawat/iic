<div class="row">
    <div class="col-lg-12">
        <?php
        if (Yii::$app->session->hasFlash('message')) {
            ?>

            <div class="alert alert-info alert-icon alert-dismissible" role="alert">
                <div class="icon"><span class="mdi mdi-info-outline"></span></div>
                <div class="message">
                    <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span class="mdi mdi-close" aria-hidden="true"></span></button>
                    <strong>Info!</strong><?= Yii::$app->session->getFlash('message') ?>
                </div>
            </div>

        <?php } ?>
        <?php
        if (Yii::$app->session->hasFlash('success')) {
            ?>

            <div class="alert alert-success alert-icon alert-dismissible" role="alert">
                <div class="icon"><span class="mdi mdi-check"></span></div>
                <div class="message">
                    <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span class="mdi mdi-close" aria-hidden="true"></span></button>
                    <strong>Great!</strong> <?= Yii::$app->session->getFlash('success') ?>
                </div>
            </div>

        <?php } ?>
        <?php
        if (Yii::$app->session->hasFlash('warning')) {
            ?>

            <div class="alert alert-warning alert-icon alert-dismissible" role="alert">
                <div class="icon"><span class="mdi mdi-alert-triangle"></span></div>
                <div class="message">
                    <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span class="mdi mdi-close" aria-hidden="true"></span></button>
                    <strong>Hey!</strong> <?= Yii::$app->session->getFlash('warning') ?>
                </div>
            </div>

        <?php } ?>
        <?php
        if (Yii::$app->session->hasFlash('danger')) {
            ?>

            <div class="alert alert-danger alert-icon alert-dismissible" role="alert">
                <div class="icon"><span class="mdi mdi-close-circle-o"></span></div>
                <div class="message">
                    <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span class="mdi mdi-close" aria-hidden="true"></span></button>
                    <strong>Alert!</strong><?= Yii::$app->session->getFlash('danger') ?>
                </div>
            </div>

        <?php } ?>
    </div>
</div>


