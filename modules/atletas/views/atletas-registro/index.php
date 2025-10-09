<?php

use app\models\AtletasRegistro;
use app\models\Escuela;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\modules\atletas\models\AtletasRegistroSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
$titulo= 'Atletas Registrados';
$this->title = $titulo;
$this->params['breadcrumbs'][] = $this->title;

// CSS para mejorar la experiencia de carga
$this->registerCss('
    .grid-loading {
        opacity: 0.6;
        pointer-events: none;
    }
    .loading-indicator {
        display: none;
        text-align: center;
        padding: 20px;
        color: #666;
        background: #f8f9fa;
        border-radius: 5px;
        margin: 10px 0;
    }
    .pjax-loading .loading-indicator {
        display: block;
    }
');
?>
<div class="atletas-registro-index">
    <section id="resgistroEscuelaClub">
    <center><h1><?= Html::encode($this->title) . '</br>' . Html::encode($nombre) ?></h1></center>

        <p>
            <?= Html::a('Registrar Atletas', ['create', 'id' => $id, 'nombre' => $nombre], ['class' => 'btn btn-success']) ?>
        </p>

        <div class="loading-indicator">
            <i class="glyphicon glyphicon-refresh glyphicon-spin"></i> Cargando atletas...
        </div>

        <?php Pjax::begin([
            'id' => 'atletas-grid-pjax',
            'timeout' => 10000, 
            'enablePushState' => true,
            'clientOptions' => [
                'container' => 'pjax-container',
            ]
        ]); ?>
        
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'layout' => "{summary}\n{items}\n{pager}",
                'tableOptions' => [
                    'class' => 'table table-striped table-bordered table-hover',
                    'style' => 'min-width: 800px;'
                ],
                'summaryOptions' => ['class' => 'summary mb-3'],
                'pager' => [
                    'options' => ['class' => 'pagination justify-content-center'],
                    'linkOptions' => ['class' => 'page-link'],
                    'disabledListItemSubTagOptions' => ['tag' => 'a', 'class' => 'page-link disabled'],
                    'maxButtonCount' => 5,
                ],
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'headerOptions' => ['style' => 'width: 50px;'],
                        'contentOptions' => ['style' => 'white-space: nowrap;']
                    ],

                    //'id',
                    //'id_club',
                    [
                        'attribute' => 'id_escuela',
                        'label' => 'Escuela',
                        'value' => function($model) {
                            // Usar relación si existe, sino consulta directa
                            if (method_exists($model, 'getEscuela') && $model->escuela) {
                                return $model->escuela->nombre;
                            } else {
                                $escuela = Escuela::findOne($model->id_escuela);
                                return $escuela ? $escuela->nombre : 'Escuela no encontrada';
                            }
                        },
                        'filter' => false,
                        'headerOptions' => ['style' => 'min-width: 150px;'],
                        'contentOptions' => ['style' => 'white-space: nowrap;']
                    ],
                    //'id_representante',
                    //'id_alergias',
                    //'id_enfermedades',
                    //'id_discapacidad',
                    [
                        'attribute' => 'identificacion',
                        'headerOptions' => ['style' => 'min-width: 120px;'],
                        'contentOptions' => ['style' => 'white-space: nowrap;']
                    ],
                    [
                        'attribute' => 'p_nombre',
                        'headerOptions' => ['style' => 'min-width: 100px;'],
                        'contentOptions' => ['style' => 'white-space: nowrap;']
                    ],
                    //'s_nombre',
                    [
                        'attribute' => 'p_apellido',
                        'headerOptions' => ['style' => 'min-width: 100px;'],
                        'contentOptions' => ['style' => 'white-space: nowrap;']
                    ],
                    //'s_apellido',
                    //'id_nac',
                    //'fn',
                    [
                        'attribute' => 'sexo',
                        'value' => function($model) {
                            return $model->sexo == 1 ? 'M' : 'F';
                        },
                        'headerOptions' => ['style' => 'width: 60px;'],
                        'contentOptions' => ['style' => 'white-space: nowrap; text-align: center;']
                    ],
                    [
                        'attribute' => 'estatura',
                        'headerOptions' => ['style' => 'width: 80px;'],
                        'contentOptions' => ['style' => 'white-space: nowrap;']
                    ],
                    [
                        'attribute' => 'peso',
                        'headerOptions' => ['style' => 'width: 80px;'],
                        'contentOptions' => ['style' => 'white-space: nowrap;']
                    ],
                    [
                        'attribute' => 'talla_franela',
                        'headerOptions' => ['style' => 'width: 80px;'],
                        'contentOptions' => ['style' => 'white-space: nowrap;']
                    ],
                    [
                        'attribute' => 'talla_short',
                        'headerOptions' => ['style' => 'width: 80px;'],
                        'contentOptions' => ['style' => 'white-space: nowrap;']
                    ],
                    [
                        'attribute' => 'cell',
                        'headerOptions' => ['style' => 'min-width: 120px;'],
                        'contentOptions' => ['style' => 'white-space: nowrap;']
                    ],
                    [
                        'attribute' => 'telf',
                        'headerOptions' => ['style' => 'min-width: 120px;'],
                        'contentOptions' => ['style' => 'white-space: nowrap;']
                    ],
                    //'asma:boolean',
                    [
                        'attribute' => 'd_creacion',
                        'format' => 'date',
                        'headerOptions' => ['style' => 'min-width: 120px;'],
                        'contentOptions' => ['style' => 'white-space: nowrap;']
                    ],
                    //'u_creacion',
                    //'d_update',
                    //'u_update',
                    //'eliminado:boolean',
                    //'dir_ip',
                    [
                        'class' => ActionColumn::className(),
                        'header' => 'Acciones',
                        'headerOptions' => ['style' => 'width: 100px;'],
                        'contentOptions' => ['style' => 'white-space: nowrap; text-align: center;'],
                        'template' => '{view} {update} {delete}',
                        'urlCreator' => function ($action, AtletasRegistro $model, $key, $index, $column) use ($id, $nombre) {
                            if ($action === 'view') {
                                return Url::toRoute([$action, 'id' => $model->id]);
                            }
                            if ($action === 'update') {
                                return Url::toRoute([$action, 'id' => $model->id]);
                            }
                            if ($action === 'delete') {
                                return Url::toRoute([$action, 'id' => $model->id]);
                            }
                            return Url::toRoute([$action, 'id' => $model->id]);
                        },
                        'buttons' => [
                            'view' => function ($url, $model, $key) {
                                return Html::a('<i class="bi bi-eye"></i>', $url, [
                                    'title' => 'Ver',
                                    'class' => 'btn btn-sm btn-info',
                                ]);
                            },
                            'update' => function ($url, $model, $key) {
                                return Html::a('<i class="bi bi-pencil"></i>', $url, [
                                    'title' => 'Actualizar',
                                    'class' => 'btn btn-sm btn-warning',
                                ]);
                            },
                            'delete' => function ($url, $model, $key) {
                                return Html::a('<i class="bi bi-trash"></i>', $url, [
                                    'title' => 'Eliminar',
                                    'class' => 'btn btn-sm btn-danger',
                                    'data-confirm' => '¿Está seguro que desea eliminar este atleta?',
                                    'data-method' => 'post',
                                ]);
                            },
                        ],
                    ],
                ],
            ]); ?>
        </div>
        
        <?php Pjax::end(); ?>
    </section>
</div>

<?php
// JavaScript para mejorar la experiencia de usuario
$this->registerJs('
    $(document).on("pjax:send", function() {
        $(".pjax-container").addClass("grid-loading");
        $(".loading-indicator").show();
    });
    $(document).on("pjax:complete", function() {
        $(".pjax-container").removeClass("grid-loading");
        $(".loading-indicator").hide();
    });
');
?>