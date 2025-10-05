<?php
// views/widgets/horizontal-menu.php
// widgets/views/horizontal-menu.php

use yii\helpers\Html;
use yii\helpers\Url;

?>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#horizontal-menu">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        
        <div class="collapse navbar-collapse" id="horizontal-menu">
            <ul class="nav navbar-nav">
                <?php foreach ($menuItems as $item): ?>
                    <?php if (isset($item['items'])): ?>
                        <li class="dropdown">
                            <?= Html::a(
                                $item['label'] . ' <span class="caret"></span>',
                                $item['url'],
                                [
                                    'class' => 'dropdown-toggle',
                                    'data-toggle' => 'dropdown',
                                    'role' => 'button',
                                    'aria-haspopup' => 'true',
                                    'aria-expanded' => 'false'
                                ]
                            ) ?>
                            <ul class="dropdown-menu">
                                <?php foreach ($item['items'] as $subItem): ?>
                                    <li><?= Html::a($subItem['label'], $subItem['url']) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li><?= Html::a($item['label'], $item['url']) ?></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</nav>