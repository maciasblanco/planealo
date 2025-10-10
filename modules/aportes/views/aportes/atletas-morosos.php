<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $atletasMorosos array */

$this->title = 'Reporte de Atletas Morosos';
$this->params['breadcrumbs'][] = ['label' => 'Aportes Semanales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="atletas-morosos-index">

    <div class="row">
        <div class="col-md-8">
            <h1>
                <i class="fas fa-exclamation-triangle text-danger"></i>
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
        <div class="col-md-4 text-right">
            <?= Html::a('<i class="fas fa-arrow-left"></i> Volver al Listado', ['index'], ['class' => 'btn btn-default']) ?>
            <?= Html::a('<i class="fas fa-file-pdf"></i> Exportar PDF', ['reporte-morosos-pdf'], [
                'class' => 'btn btn-danger',
                'target' => '_blank',
                'data' => ['method' => 'post']
            ]) ?>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-danger text-white">
            <h4 class="mb-0">
                <i class="fas fa-list"></i>
                Lista de Atletas con Aportes Pendientes
            </h4>
        </div>
        <div class="card-body">
            <?php if (empty($atletasMorosos)): ?>
                <div class="alert alert-success text-center">
                    <i class="fas fa-check-circle fa-2x"></i>
                    <h4>¡Excelente! No hay atletas morosos</h4>
                    <p>Todos los aportes están al día.</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th width="50px">#</th>
                                <th>Atleta</th>
                                <th>Escuela</th>
                                <th class="text-center">Semanas en Deuda</th>
                                <th class="text-right">Total Deuda</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $totalGeneralDeuda = 0;
                            $totalGeneralSemanas = 0;
                            ?>
                            <?php foreach ($atletasMorosos as $index => $moroso): ?>
                                <?php 
                                $totalGeneralDeuda += floatval($moroso['total_deuda']);
                                $totalGeneralSemanas += intval($moroso['semanas_deuda']);
                                ?>
                                <tr>
                                    <td class="text-center"><?= $index + 1 ?></td>
                                    <td>
                                        <strong><?= Html::encode($moroso['nombre_completo']) ?></strong>
                                    </td>
                                    <td><?= Html::encode($moroso['escuela_nombre']) ?></td>
                                    <td class="text-center">
                                        <span class="badge badge-warning badge-pill">
                                            <?= $moroso['semanas_deuda'] ?> semana(s)
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <span class="text-danger font-weight-bold">
                                            $<?= number_format($moroso['total_deuda'], 2) ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <?= Html::a('<i class="fas fa-eye"></i>', ['index', 'AportesSemanalesSearch[atleta_id]' => 'TODO'], [
                                            'class' => 'btn btn-sm btn-info',
                                            'title' => 'Ver detalles del atleta',
                                            'data-toggle' => 'tooltip'
                                        ]) ?>
                                        <?= Html::a('<i class="fas fa-money-bill-wave"></i>', ['registro-masivo'], [
                                            'class' => 'btn btn-sm btn-success',
                                            'title' => 'Registrar pago',
                                            'data-toggle' => 'tooltip'
                                        ]) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot class="bg-light">
                            <tr>
                                <th colspan="3" class="text-right"><strong>TOTALES GENERALES:</strong></th>
                                <th class="text-center">
                                    <span class="badge badge-dark badge-pill">
                                        <?= $totalGeneralSemanas ?> semana(s)
                                    </span>
                                </th>
                                <th class="text-right">
                                    <span class="text-danger font-weight-bold">
                                        $<?= number_format($totalGeneralDeuda, 2) ?>
                                    </span>
                                </th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Resumen Estadístico -->
                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="info-box bg-danger">
                            <span class="info-box-icon"><i class="fas fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Atletas Morosos</span>
                                <span class="info-box-number"><?= count($atletasMorosos) ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-box bg-warning">
                            <span class="info-box-icon"><i class="fas fa-calendar-week"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Semanas Deuda</span>
                                <span class="info-box-number"><?= $totalGeneralSemanas ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-box bg-dark">
                            <span class="info-box-icon"><i class="fas fa-money-bill-wave"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Deuda Total</span>
                                <span class="info-box-number">$<?= number_format($totalGeneralDeuda, 2) ?></span>
                            </div>
                        </div>
                    </div>
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
                    <li>Este reporte muestra los atletas que tienen aportes semanales con estado "Pendiente"</li>
                    <li>El monto de cada aporte semanal es de <strong>$2.00</strong> por semana</li>
                    <li>La deuda se calcula sumando todos los aportes pendientes de cada atleta</li>
                    <li>Los datos se actualizan automáticamente según los registros en el sistema</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php
// JavaScript para mejorar la interactividad
$this->registerJs(<<<JS
    $(document).ready(function() {
        // Inicializar tooltips
        $('[data-toggle="tooltip"]').tooltip();
        
        // Ordenar la tabla por deuda total (descendente) por defecto
        $('table').DataTable({
            "order": [[4, "desc"]],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
            },
            "responsive": true,
            "dom": '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            "pageLength": 25
        });
    });
JS
);

// CSS adicional para mejorar la apariencia
$this->registerCss(<<<CSS
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
CSS
);
?>