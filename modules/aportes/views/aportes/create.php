<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\AtletasRegistro;
use app\models\Escuela;
use app\models\AportesSemanales;

/* @var $this yii\web\View */
/* @var $model app\models\AportesSemanales */
/* @var $atletas array */
/* @var $escuelas array */

$this->title = 'Nuevo Aporte Semanal';
$this->params['breadcrumbs'][] = ['label' => 'Aportes Semanales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="aportes-semanales-create">

    <div class="row">
        <div class="col-md-8">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="col-md-4 text-right">
            <?= Html::a('<i class="fas fa-arrow-left"></i> Volver al Listado', ['index'], ['class' => 'btn btn-default']) ?>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <?php $form = ActiveForm::begin([
                'id' => 'aporte-semanales-form',
            ]); ?>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'atleta_id')->dropDownList(
                        ArrayHelper::map($atletas, 'id', function($atleta) {
                            $nombre = trim($atleta->p_nombre . ' ' . $atleta->p_apellido);
                            $segundo = trim($atleta->s_nombre . ' ' . $atleta->s_apellido);
                            $nombreCompleto = $nombre . ($segundo ? ' ' . $segundo : '');
                            return $nombreCompleto . ' (' . $atleta->identificacion . ')';
                        }),
                        [
                            'prompt' => 'Seleccionar atleta...',
                            'class' => 'form-control select2'
                        ]
                    )->label('Atleta') ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'escuela_id')->dropDownList(
                        ArrayHelper::map($escuelas, 'id', 'nombre'),
                        [
                            'prompt' => 'Seleccionar escuela...',
                            'class' => 'form-control select2'
                        ]
                    )->label('Escuela') ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'fecha_viernes')->textInput([
                        'type' => 'date',
                        'class' => 'form-control'
                    ])->label('Fecha del Viernes') ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'numero_semana')->textInput([
                        'type' => 'number',
                        'class' => 'form-control'
                    ])->label('Número de Semana') ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'monto')->textInput([
                        'type' => 'number',
                        'step' => '0.01',
                        'class' => 'form-control'
                    ])->label('Monto ($)') ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'estado')->dropDownList(
                        [
                            'pendiente' => 'Pendiente',
                            'pagado' => 'Pagado',
                            'cancelado' => 'Cancelado'
                        ],
                        [
                            'prompt' => 'Seleccionar estado...',
                            'class' => 'form-control'
                        ]
                    )->label('Estado del Pago') ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'fecha_pago')->textInput([
                        'type' => 'date',
                        'class' => 'form-control'
                    ])->label('Fecha de Pago (si aplica)') ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'metodo_pago')->dropDownList(
                        [
                            'efectivo' => 'Efectivo',
                            'transferencia' => 'Transferencia',
                            'pago_movil' => 'Pago Móvil',
                            'tarjeta' => 'Tarjeta',
                            'otro' => 'Otro'
                        ],
                        [
                            'prompt' => 'Seleccionar método...',
                            'class' => 'form-control'
                        ]
                    )->label('Método de Pago') ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($model, 'comentarios')->textarea([
                        'rows' => 3,
                        'class' => 'form-control',
                        'placeholder' => 'Observaciones o comentarios adicionales...'
                    ])->label('Comentarios') ?>
                </div>
            </div>

            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> 
                <strong>Información:</strong> 
                El monto sugerido es de <strong>$<?= number_format(AportesSemanales::MONTO_SEMANAL, 2) ?></strong> por semana. 
                La fecha del viernes y número de semana se calculan automáticamente si se dejan en blanco.
            </div>

            <div class="form-group">
                <?= Html::submitButton('<i class="fas fa-save"></i> Guardar Aporte Semanal', [
                    'class' => 'btn btn-success btn-lg'
                ]) ?>
                <?= Html::a('<i class="fas fa-times"></i> Cancelar', ['index'], [
                    'class' => 'btn btn-default btn-lg'
                ]) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<?php
// JavaScript para mejorar la experiencia de usuario
$this->registerJs(<<<JS
    $(document).ready(function() {
        // Establecer valores por defecto si están vacíos
        if ($('#aportessemanales-fecha_viernes').val() === '') {
            var hoy = new Date();
            var viernes = new Date(hoy);
            // Si hoy no es viernes, calcular el último viernes
            if (hoy.getDay() !== 5) {
                var diff = (hoy.getDay() <= 5) ? (hoy.getDay() - 5) : (hoy.getDay() - 5 - 7);
                viernes.setDate(hoy.getDate() + diff);
            }
            var fechaFormateada = viernes.toISOString().split('T')[0];
            $('#aportessemanales-fecha_viernes').val(fechaFormateada);
        }

        if ($('#aportessemanales-numero_semana').val() === '') {
            var fecha = $('#aportessemanales-fecha_viernes').val();
            if (fecha) {
                var fechaObj = new Date(fecha);
                var inicioAnio = new Date(fechaObj.getFullYear(), 0, 1);
                var dias = Math.floor((fechaObj - inicioAnio) / (24 * 60 * 60 * 1000));
                var numeroSemana = Math.ceil((fechaObj.getDay() + 1 + dias) / 7);
                $('#aportessemanales-numero_semana').val(numeroSemana);
            }
        }

        if ($('#aportessemanales-monto').val() === '') {
            $('#aportessemanales-monto').val('2.00');
        }

        // Cuando cambia la fecha, recalcular número de semana
        $('#aportessemanales-fecha_viernes').change(function() {
            var fecha = $(this).val();
            if (fecha) {
                var fechaObj = new Date(fecha);
                var inicioAnio = new Date(fechaObj.getFullYear(), 0, 1);
                var dias = Math.floor((fechaObj - inicioAnio) / (24 * 60 * 60 * 1000));
                var numeroSemana = Math.ceil((fechaObj.getDay() + 1 + dias) / 7);
                $('#aportessemanales-numero_semana').val(numeroSemana);
            }
        });

        // Cuando se selecciona un atleta, intentar cargar su escuela automáticamente
        $('#aportessemanales-atleta_id').change(function() {
            var atletaId = $(this).val();
            if (atletaId) {
                // En una implementación real, harías una llamada AJAX para obtener los datos del atleta
                // Por ahora, esto es un placeholder para la funcionalidad futura
                console.log('Atleta seleccionado:', atletaId);
            }
        });

        // Inicializar Select2 si está disponible
        if ($.fn.select2) {
            $('.select2').select2({
                width: '100%',
                placeholder: 'Seleccione una opción...',
                allowClear: true
            });
        }
    });
JS
);

// CSS adicional para mejorar la apariencia
$this->registerCss(<<<CSS
    .select2-container--default .select2-selection--single {
        height: 38px;
        padding: 6px 12px;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px;
    }
    .alert-info {
        border-left: 4px solid #17a2b8;
    }
CSS
);
?>