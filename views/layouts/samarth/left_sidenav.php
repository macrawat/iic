<div class="be-left-sidebar">
    <div class="left-sidebar-wrapper"><a class="left-sidebar-toggle" href="#">Samarth Menu</a>
        <div class="left-sidebar-spacer">
            <div class="left-sidebar-scroll">
                <div class="left-sidebar-content">
                    <?php

                    use yii\widgets\Menu;

                    echo Menu::widget([
                        'options' => [
                            'class' => 'sidebar-elements',
                        ],
                        'linkTemplate' => '<a href="{url}">{label}</a>',
                        'submenuTemplate' => '<ul class="submenu">{items}</ul>',
                        'encodeLabels' => false,
                        'items' => [
                            [
                                'label' => '<span class="icons mdi mdi-view-subtitles"></span>Home',
                                'url' => '#',
                                'options' => [
                                    'class' => 'parent',
                                ],
                                'class' => 'submenu',
                                'items' => [
                                    ['label' => 'Sub Menu 1', 'url' => ['/site/index']],
                                    ['label' => 'Sub Menu 2', 'url' => ['#']],
                                ]
                            ],
                            [
                                'label' => '<span class="icons mdi mdi-view-subtitles"></span>Module',
                                'url' => '#',
                                'options' => [
                                    'class' => 'parent',
                                ],
                                'class' => 'submenu',
                                'items' => [
                                    ['label' => 'Sub Menu 1', 'url' => ['/demomodule']],
                                    ['label' => 'Form Template', 'url' => ['/demomodule/app/form-template']],
                                    ['label' => 'Dependent Dropdown', 'url' => ['/demomodule/app/dependent-dropdown']],
                                    ['label' => 'Modal Widget', 'url' => ['/demomodule/app/modal-widget']],
                                    

                                ]
                            ],

                        ]
                    ]);
                    ?>

                </div>
            </div>
        </div>
        <div class="progress-widget">
            <div class="progress-data"><span class="progress-value"></span><span
                        class="name">© <?= Yii::$app->params['parent.organisation'] ?> | <?= date('Y') ?></span></div>
            <div class="progress">
                <div class="progress-bar progress-bar-primary" style="width: 100%;"></div>
            </div>
        </div>
    </div>
</div>