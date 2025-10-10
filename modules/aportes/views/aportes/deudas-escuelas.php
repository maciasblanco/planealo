<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $deudasPorEscuela array */

$this->title = 'Reporte de Deudas por Escuela';
$this->params['breadcrumbs'][] = ['label' => 'Aportes Semanales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

// Calcular totales
$totalDeudaGeneral = 0;
$totalAtletasDeudores = 0;
foreach ($deudasPorEscuela as $deuda) {
    $totalDeudaGeneral += floatval($deuda['total_deuda']);
    $totalAtletasDeudores += intval($deuda['atletas_deudores']);
}
?>

<div class="deudas-escuelas-index">

    <div class="row">
        <div class="col-md-8">
            <h1>
                <i class="fas fa-school text-warning"></i>
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
        <div class="col-md-4 text-right">
            <?= Html::a('<i class="fas fa-arrow-left"></i> Volver al Listado', ['index'], ['class' => 'btn btn-default']) ?>
            <?= Html::a('<i class="fas fa-file-pdf"></i> Exportar PDF', ['#'], [
                'class' => 'btn btn-warning',
                'onclick' => 'alert("Funcionalidad de PDF en desarrollo")'
            ]) ?>
            <?= Html::a('<i class="fas fa-file-excel"></i> Exportar Excel', ['#'], [
                'class' => 'btn btn-success',
                'onclick' => 'alert("Funcionalidad de Excel en desarrollo")'
            ]) ?>
        </div>
    </div>

    <!-- Panel de Estadísticas -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="info-box bg-warning">
                <span class="info-box-icon"><i class="fas fa-school"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Escuelas con Deuda</span>
                    <span class="info-box-number"><?= count($deudasPorEscuela) ?></span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box bg-danger">
                <span class="info-box-icon"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Atletas Deudores</span>
                    <span class="info-box-number"><?= $totalAtletasDeudores ?></span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box bg-dark">
                <span class="info-box-icon"><i class="fas fa-money-bill-wave"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Deuda Total General</span>
                    <span class="info-box-number">$<?= number_format($totalDeudaGeneral, 2) ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-warning text-dark">
            <h4 class="mb-0">
                <i class="fas fa-list"></i>
                Detalle de Deudas por Escuela
            </h4>
        </div>
        <div class="card-body">
            <?php if (empty($deudasPorEscuela)): ?>
                <div class="alert alert-success text-center">
                    <i class="fas fa-check-circle fa-2x"></i>
                    <h4>¡Excelente! No hay deudas pendientes</h4>
                    <p>Todas las escuelas están al día con sus aportes.</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered" id="tabla-deudas">
                        <thead class="thead-dark">
                            <tr>
                                <th width="50px">#</th>
                                <th>Escuela</th>
                                <th class="text-center">Atletas con Deuda</th>
                                <th class="text-right">Deuda Total</th>
                                <th class="text-center">Deuda Promedio por Atleta</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($deudasPorEscuela as $index => $escuela): ?>
                                <?php 
                                $deudaPromedio = $escuela['atletas_deudores'] > 0 
                                    ? $escuela['total_deuda'] / $escuela['atletas_deudores'] 
                                    : 0;
                                ?>
                                <tr>
                                    <td class="text-center"><?= $index + 1 ?></td>
                                    <td>
                                        <strong><?= Html::encode($escuela['nombre']) ?></strong>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-info badge-pill">
                                            <?= $escuela['atletas_deudores'] ?> atleta(s)
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <span class="text-danger font-weight-bold">
                                            $<?= number_format($escuela['total_deuda'], 2) ?>
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <span class="text-warning font-weight-bold">
                                            $<?= number_format($deudaPromedio, 2) ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <?= Html::a('<i class="fas fa-eye"></i>', ['index'], [
                                            'class' => 'btn btn-sm btn-info',
                                            'title' => 'Ver todos los aportes',
                                            'data-toggle' => 'tooltip'
                                        ]) ?>
                                        <?= Html::a('<i class="fas fa-envelope"></i>', ['#'], [
                                            'class' => 'btn btn-sm btn-warning',
                                            'title' => 'Enviar recordatorio',
                                            'data-toggle' => 'tooltip',
                                            'onclick' => 'alert("Funcionalidad de notificación en desarrollo")'
                                        ]) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot class="bg-light">
                            <tr>
                                <th colspan="2" class="text-right"><strong>TOTALES GENERALES:</strong></th>
                                <th class="text-center">
                                    <span class="badge badge-dark badge-pill">
                                        <?= $totalAtletasDeudores ?> atleta(s)
                                    </span>
                                </th>
                                <th class="text-right">
                                    <span class="text-danger font-weight-bold">
                                        $<?= number_format($totalDeudaGeneral, 2) ?>
                                    </span>
                                </th>
                                <th class="text-right">
                                    <span class="text-warning font-weight-bold">
                                        $<?= number_format($totalAtletasDeudores > 0 ? $totalDeudaGeneral / $totalAtletasDeudores : 0, 2) ?>
                                    </span>
                                </th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Información adicional -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="alert alert-info">
                <h5><i class="fas fa-info-circle"></i> Información del Reporte</h5>
                <ul class="mb-0">
                    <li>Este reporte muestra las escuelas que tienen atletas con aportes semanales pendientes</li>
                    <li>El monto de cada aporte semanal es de <strong>$2.00</strong> por semana</li>
                    <li>La deuda total se calcula sumando todos los aportes pendientes de los atletas de cada escuela</li>
                    <li>Los datos se actualizan automáticamente según los registros en el sistema</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php
// JavaScript simplificado y corregido
$js = <<<JS
$(document).ready(function() {
    // Inicializar tooltips
    $('[data-toggle="tooltip"]').tooltip();
    
    // Inicializar DataTable
    $('#tabla-deudas').DataTable({
        "order": [[3, "desc"]],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
        },
        "responsive": true,
        "dom": '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        "pageLength": 25
    });
});
JS;

$this->registerJs($js);

// CSS adicional para mejorar la apariencia
$css = <<<CSS
.info-box {
    box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
    border-radius: 0.25rem;
    background: #fff;
    display: flex;
    margin-bottom: 1rem;
    min-height: 80px;
    padding: 0.5rem;
    position: relative;
}
.info-box .info-box-icon {
    border-radius: 0.25rem;
    align-items: center;
    display: flex;
    font-size: 1.875rem;
    justify-content: center;
    text-align: center;
    width: 70px;
}
.info-box .info-box-content {
    display: flex;
    flex-direction: column;
    justify-content: center;
    line-height: 1.8;
    flex: 1;
    padding: 0 10px;
}
.info-box .info-box-text {
    display: block;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    text-transform: uppercase;
    font-weight: bold;
    font-size: 0.875rem;
}
.info-box .info-box-number {
    display: block;
    font-weight: bold;
    font-size: 1.5rem;
}
.table th {
    border-top: none;
    font-weight: 600;
}
.badge-pill {
    border-radius: 10rem;
    padding: 0.25em 0.6em;
    font-size: 0.75em;
}
.bg-warning {
    background-color: #ffc107 !important;
}
.bg-danger {
    background-color: #dc3545 !important;
}
.bg-dark {
    background-color: #343a40 !important;
}
.bg-info {
    background-color: #17a2b8 !important;
}
CSS;

$this->registerCss($css);

// Incluir DataTables si no está incluido
$this->registerJsFile('https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerCssFile('https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css');
?>