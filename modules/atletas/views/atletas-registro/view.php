<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\AtletasRegistro $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Atletas Registros', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="atletas-registro-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_club',
            'id_escuela',
            'id_representante',
            'id_alergias',
            'id_enfermedades',
            'id_discapacidad',
            'p_nombre',
            's_nombre',
            'p_apellido',
            's_apellido',
            'id_nac',
            'identificacion',
            'fn',
            'sexo',
            'estatura',
            'peso',
            'talla_franela',
            'talla_short',
            'cell',
            'telf',
            'asma:boolean',
            'd_creacion',
            'u_creacion',
            'd_update',
            'u_update',
            'eliminado:boolean',
            'dir_ip',
        ],
    ]) ?>

</div>
