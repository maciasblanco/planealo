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

$this->title = 'Gestión de Aportes Semanales';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aportes-index">

    <!-- Header Mejorado -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="page-header">
                <i class="fas fa-money-bill-wave text-primary"></i>
                <?= Html::encode($this->title) ?>
            </h1>
            <p class="text-muted">Administre los aportes semanales de los atletas del sistema</p>
        </div>
        <div class="col-md-4 text-right">
            <div class="btn-group">
                <?= Html::a('<i class="fas fa-sync-alt"></i>', ['index'], [
                    'class' => 'btn btn-outline-secondary',
                    'title' => 'Actualizar página'
                ]) ?>
                <?= Html::a('<i class="fas fa-question-circle"></i>', ['#'], [
                    'class' => 'btn btn-outline-secondary',
                    'title' => 'Ayuda',
                    'onclick' => 'alert("Módulo de Aportes Semanales - Gestión completa de pagos")'
                ]) ?>
            </div>
        </div>
    </div>

    <!-- PANEL DE ESTADÍSTICAS MEJORADO -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Recaudado
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                $<?= number_format($totalRecaudado, 2) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Aportes Pendientes
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= number_format($pendientes) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Deuda Total
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                $<?= number_format($deudaTotal, 2) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Atletas con Deuda
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= number_format($atletasConDeuda) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BOTONES DE ACCIÓN MEJORADOS -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-tasks"></i> Acciones Rápidas
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="btn-group btn-group-lg" role="group">
                                <?= Html::a('<i class="fas fa-plus-circle"></i> Individual', ['create'], [
                                    'class' => 'btn btn-success btn-lg'
                                ]) ?>
                                <?= Html::a('<i class="fas fa-users"></i> Masivo', ['registro-masivo'], [
                                    'class' => 'btn btn-primary btn-lg'
                                ]) ?>
                                <?= Html::a('<i class="fas fa-chart-bar"></i> Reporte', ['reporte'], [
                                    'class' => 'btn btn-info btn-lg'
                                ]) ?>
                            </div>
                        </div>
                        <div class="col-md-4 text-right">
                            <div class="btn-group" role="group">
                                <?= Html::a('<i class="fas fa-exclamation-triangle"></i>', ['atletas-morosos'], [
                                    'class' => 'btn btn-outline-danger',
                                    'title' => 'Atletas Morosos',
                                    'data-toggle' => 'tooltip'
                                ]) ?>
                                <?= Html::a('<i class="fas fa-school"></i>', ['deudas-escuelas'], [
                                    'class' => 'btn btn-outline-warning',
                                    'title' => 'Deudas por Escuela',
                                    'data-toggle' => 'tooltip'
                                ]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PANEL DE BÚSQUEDA Y FILTROS -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-table"></i> Listado de Aportes Semanales
            </h6>
            <div class="dropdown">
                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" 
                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-cog"></i> Opciones
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#" onclick="$('#search-container').toggle();">
                        <i class="fas fa-search"></i> Mostrar/Ocultar Búsqueda
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-columns"></i> Personalizar Columnas
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <!-- Filtros de Búsqueda -->
            <div id="search-container" class="mb-3" style="display: none;">
                <div class="card border-left-primary">
                    <div class="card-body">
                        <h6 class="card-title text-primary">
                            <i class="fas fa-filter"></i> Filtros de Búsqueda
                        </h6>
                        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
                    </div>
                </div>
            </div>

            <!-- GridView Mejorado -->
            <?php Pjax::begin(['id' => 'aportes-grid', 'timeout' => 10000]); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'options' => [
                    'class' => 'table-responsive',
                    'id' => 'aportes-table'
                ],
                'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
                'layout' => "{summary}\n{items}\n<div class='d-flex justify-content-between align-items-center'>{pager}\n<div class='text-muted small'>Mostrando {count} de {totalCount} registros</div></div>",
                'summary' => '<div class="summary alert alert-info">Mostrando <b>{begin}-{end}</b> de <b>{totalCount}</b> elementos.</div>',
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'header' => '#',
                        'contentOptions' => ['class' => 'text-center', 'style' => 'width: 50px;']
                    ],
                    
                    [
                        'attribute' => 'atleta_id',
                        'value' => function($model) {
                            $atleta = $model->atleta;
                            if ($atleta) {
                                $nombre = trim($atleta->p_nombre . ' ' . $atleta->p_apellido);
                                $segundo = trim($atleta->s_nombre . ' ' . $atleta->s_apellido);
                                $nombreCompleto = $nombre . ($segundo ? ' ' . $segundo : '');
                                return '<strong>' . Html::encode($nombreCompleto) . '</strong>' .
                                       '<br><small class="text-muted">' . Html::encode($atleta->identificacion) . '</small>';
                            }
                            return '<span class="text-danger">N/A</span>';
                        },
                        'format' => 'raw',
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
                            return $model->escuela ? 
                                '<span class="badge badge-light border">' . Html::encode($model->escuela->nombre) . '</span>' : 
                                '<span class="text-danger">N/A</span>';
                        },
                        'format' => 'raw',
                        'filter' => \yii\helpers\ArrayHelper::map(
                            \app\models\Escuela::find()->all(), 'id', 'nombre'
                        )
                    ],
                    [
                        'attribute' => 'fecha_viernes',
                        'format' => 'date',
                        'contentOptions' => ['class' => 'text-center'],
                        'headerOptions' => ['class' => 'text-center']
                    ],
                    [
                        'attribute' => 'numero_semana',
                        'contentOptions' => ['class' => 'text-center'],
                        'headerOptions' => ['class' => 'text-center']
                    ],
                    [
                        'attribute' => 'monto',
                        'value' => function($model) {
                            return '<span class="font-weight-bold text-success">$' . number_format($model->monto, 2) . '</span>';
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-right'],
                        'headerOptions' => ['class' => 'text-right']
                    ],
                    [
                        'attribute' => 'estado',
                        'value' => function($model) {
                            $badgeClass = [
                                'pendiente' => 'warning',
                                'pagado' => 'success',
                                'cancelado' => 'danger'
                            ][$model->estado] ?? 'secondary';
                            
                            return '<span class="badge badge-' . $badgeClass . ' badge-pill">' . 
                                   ucfirst($model->estado) . '</span>';
                        },
                        'format' => 'raw',
                        'filter' => [
                            'pendiente' => 'Pendiente',
                            'pagado' => 'Pagado',
                            'cancelado' => 'Cancelado'
                        ],
                        'contentOptions' => ['class' => 'text-center'],
                        'headerOptions' => ['class' => 'text-center']
                    ],
                    [
                        'attribute' => 'fecha_pago',
                        'format' => 'date',
                        'contentOptions' => ['class' => 'text-center'],
                        'headerOptions' => ['class' => 'text-center']
                    ],
                    [
                        'attribute' => 'metodo_pago',
                        'value' => function($model) {
                            return $model->metodo_pago ? 
                                '<small class="text-muted">' . ucfirst($model->metodo_pago) . '</small>' : 
                                '<span class="text-muted">-</span>';
                        },
                        'format' => 'raw'
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '<div class="btn-group">{view}{update}{delete}{pagar}</div>',
                        'buttons' => [
                            'view' => function($url, $model, $key) {
                                return Html::a('<i class="fas fa-eye"></i>', $url, [
                                    'class' => 'btn btn-sm btn-outline-info',
                                    'title' => 'Ver detalles',
                                    'data-toggle' => 'tooltip'
                                ]);
                            },
                            'update' => function($url, $model, $key) {
                                return Html::a('<i class="fas fa-edit"></i>', $url, [
                                    'class' => 'btn btn-sm btn-outline-warning',
                                    'title' => 'Editar',
                                    'data-toggle' => 'tooltip'
                                ]);
                            },
                            'delete' => function($url, $model, $key) {
                                return Html::a('<i class="fas fa-trash"></i>', $url, [
                                    'class' => 'btn btn-sm btn-outline-danger',
                                    'title' => 'Eliminar',
                                    'data-toggle' => 'tooltip',
                                    'data' => [
                                        'confirm' => '¿Está seguro de eliminar este aporte?',
                                        'method' => 'post',
                                    ]
                                ]);
                            },
                            'pagar' => function($url, $model, $key) {
                                if ($model->estado == 'pendiente') {
                                    return Html::a('<i class="fas fa-check-circle"></i>', 
                                        ['marcar-pagado', 'id' => $model->id], 
                                        [
                                            'class' => 'btn btn-sm btn-outline-success',
                                            'title' => 'Marcar como pagado',
                                            'data-toggle' => 'tooltip',
                                            'data' => [
                                                'confirm' => '¿Está seguro de marcar este aporte como PAGADO?',
                                                'method' => 'post',
                                            ]
                                        ]);
                                }
                                return '';
                            }
                        ],
                        'contentOptions' => [
                            'class' => 'text-center',
                            'style' => 'width: 180px; min-width: 180px;'
                        ],
                        'headerOptions' => ['class' => 'text-center'],
                        'header' => 'Acciones'
                    ],
                ],
                'pager' => [
                    'options' => ['class' => 'pagination justify-content-center'],
                    'linkContainerOptions' => ['class' => 'page-item'],
                    'linkOptions' => ['class' => 'page-link'],
                    'disabledListItemSubTagOptions' => ['class' => 'page-link'],
                ]
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>

    <!-- Información Adicional -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="alert alert-light border">
                <h6 class="alert-heading">
                    <i class="fas fa-info-circle text-info"></i> Información del Módulo
                </h6>
                <p class="mb-2">
                    <strong>Monto por semana:</strong> $2.00 | 
                    <strong>Frecuencia:</strong> Cada viernes | 
                    <strong>Total registros:</strong> <?= $dataProvider->getTotalCount() ?>
                </p>
                <hr>
                <small class="text-muted">
                    <i class="fas fa-clock"></i> Última actualización: <?= date('d/m/Y H:i:s') ?>
                </small>
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
    
    // Alternar visibilidad de filtros
    $('#toggle-filters').click(function() {
        $('#search-container').slideToggle();
    });
    
    // Mejorar la experiencia del DataTable
    $('#aportes-table').DataTable({
        "responsive": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
        },
        "dom": '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        "pageLength": 20,
        "order": [[3, 'desc']] // Ordenar por fecha_viernes descendente
    });
    
    // Auto-ocultar mensajes flash después de 5 segundos
    setTimeout(function() {
        $('.alert:not(.alert-permanent)').fadeOut('slow');
    }, 5000);
});
JS
);

// CSS adicional para mejorar el diseño
$this->registerCss(<<<CSS
.page-header {
    border-bottom: 1px solid #eee;
    padding-bottom: 10px;
    margin-bottom: 20px;
}

.card {
    border: none;
    border-radius: 0.5rem;
}

.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}

.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}

.border-left-danger {
    border-left: 0.25rem solid #e74a3b !important;
}

.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}

.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}

.shadow {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
}

.btn-group-lg > .btn, .btn-lg {
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
    border-radius: 0.35rem;
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #6e707e;
    background-color: #f8f9fc;
}

.badge-pill {
    border-radius: 10rem;
    padding: 0.25em 0.6em;
    font-size: 0.75em;
}

.dropdown-menu {
    border: none;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
}

.summary {
    border: none;
    border-radius: 0.35rem;
    margin-bottom: 1rem;
}

/* Responsive improvements */
@media (max-width: 768px) {
    .btn-group-lg {
        display: flex;
        flex-direction: column;
    }
    .btn-group-lg .btn {
        margin-bottom: 0.5rem;
        border-radius: 0.35rem !important;
    }
    .card-body .btn-group {
        flex-wrap: wrap;
    }
}
CSS
);

// Incluir DataTables si no está incluido
$this->registerJsFile('https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js', 
    ['depends' => [\yii\web\JqueryAsset::class]]
);
$this->registerCssFile('https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css');
?>