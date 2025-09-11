<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Escuela $model */

$this->title = 'Create Escuela';
$this->params['breadcrumbs'][] = ['label' => 'Escuelas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="escuela-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
