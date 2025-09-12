<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\AtletasRegistro $model */

$this->title = 'Registro de Atletas';
$this->params['breadcrumbs'][] = ['label' => 'Registro de Atletas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="atletas-registro-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
