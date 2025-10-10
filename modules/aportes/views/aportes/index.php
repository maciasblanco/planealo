<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\aportes\models\AportesSemanalesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $totalRecaudado float */
/* @var $pendientes int */
/* @var $deudaTotal float */
/* @var $atletasConDeuda int */

$this->title = 'Gestión de Aportes Semanales - Viernes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aportes-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- PANEL DE ESTADÍSTICAS MEJORADO -->
    <div class="row">
        <div class="col-md-3">
            <div class="info-box bg-success">
                <div class="info-box-content">
                    <span class="info-box-text">Total Recaudado</span>
                    <span class="info-box-number">$<?= number_format($totalRecaudado, 2) ?></span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box bg-warning">
                <div class="info-box-content">
                    <span class="info-box-text">Aportes Pendientes</span>
                    <span class="info-box-number"><?= $pendientes ?></span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box bg-danger">
                <div class="info-box-content">
                    <span class="info-box-text">Deuda Total</span>
                    <span class="info-box-number">$<?= number_format($deudaTotal, 2) ?></span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box bg-info">
                <div class="info-box-content">
                    <span class="info-box-text">Atletas con Deuda</span>
                    <span class="info-box-number"><?= $atletasConDeuda ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- BOTONES DE ACCIÓN MEJORADOS -->
    <div class="row mb-3">
        <div class="col-md-12">
            <?= Html::a('<i class="fas fa-plus"></i> Registrar Aporte Individual', ['create'], ['class' => 'btn btn-success']) ?>
            <?= Html::a('<i class="fas fa-users"></i> Registro Masivo', ['registro-masivo'], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('<i class="fas fa-exclamation-triangle"></i> Atletas Morosos', ['atletas-morosos'], ['class' => 'btn btn-danger']) ?>
            <?= Html::a('<i class="fas fa-school"></i> Deudas por Escuela', ['deudas-escuelas'], ['class' => 'btn btn-warning']) ?>
            <?= Html::a('<i class="fas fa-file-pdf"></i> Generar Reporte', ['reporte'], ['class' => 'btn btn-info', 'target' => '_blank']) ?>
        </div>
    </div>

    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            [
                'attribute' => 'atleta_id',
                'value' => function($model) {
                    $atleta = $model->atleta;
                    if ($atleta) {
                        $nombre = trim($atleta->p_nombre . ' ' . $atleta->p_apellido);
                        $segundo = trim($atleta->s_nombre . ' ' . $atleta->s_apellido);
                        return $nombre . ($segundo ? ' ' . $segundo : '');
                    }
                    return 'N/A';
                },
                'filter' => \yii\helpers\ArrayHelper::map(
                    \app\models\AtletasRegistro::find()->all(), 
                    'id', 
                    function($atleta) {
                        return trim($atleta->p_nombre . ' ' . $atleta->p_apellido);
                    }
                )
            ],
            [
                'attribute' => 'escuela_id',
                'value' => function($model) {
                    return $model->escuela->nombre ?? 'N/A';
                },
                'filter' => \yii\helpers\ArrayHelper::map(
                    \app\models\Escuela::find()->all(), 'id', 'nombre'
                )
            ],
            'fecha_viernes',
            'numero_semana',
            [
                'attribute' => 'monto',
                'value' => function($model) {
                    return '$' . number_format($model->monto, 2);
                }
            ],
            [
                'attribute' => 'estado',
                'value' => function($model) {
                    $badge = $model->estado == 'pagado' ? 'success' : 
                            ($model->estado == 'pendiente' ? 'warning' : 'danger');
                    return '<span class="badge badge-'.$badge.'">'.ucfirst($model->estado).'</span>';
                },
                'format' => 'raw',
                'filter' => [
                    'pendiente' => 'Pendiente',
                    'pagado' => 'Pagado',
                    'cancelado' => 'Cancelado'
                ]
            ],
            'fecha_pago',
            'metodo_pago',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {pagar}',
                'buttons' => [
                    'pagar' => function($url, $model, $key) {
                        if ($model->estado == 'pendiente') {
                            return Html::a('<span class="fas fa-money-bill"></span>', 
                                ['marcar-pagado', 'id' => $model->id], 
                                [
                                    'title' => 'Marcar como pagado',
                                    'data' => [
                                        'confirm' => '¿Está seguro de marcar este aporte como PAGADO?',
                                        'method' => 'post',
                                    ],
                                    'class' => 'btn btn-sm btn-success'
                                ]);
                        }
                        return '';
                    }
                ]
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>