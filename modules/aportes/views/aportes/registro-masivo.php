<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\AtletasRegistro;
use app\models\Escuela;

/* @var $this yii\web\View */
/* @var $model app\models\AportesSemanales */
/* @var $atletas array */
/* @var $fechaViernes string */
/* @var $numeroSemana int */

$this->title = 'Registro Masivo de Aportes Semanales';
$this->params['breadcrumbs'][] = ['label' => 'Aportes Semanales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="aportes-semanales-registro-masivo">

    <div class="row">
        <div class="col-md-8">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="col-md-4 text-right">
            <?= Html::a('<i class="fas fa-arrow-left"></i> Volver al Listado', ['index'], ['class' => 'btn btn-default']) ?>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-info text-white">
            <h4 class="mb-0">
                <i class="fas fa-calendar-week"></i> 
                Semana #<?= $numeroSemana ?> - Viernes: <?= Yii::$app->formatter->asDate($fechaViernes, 'long') ?>
            </h4>
        </div>
        <div class="card-body">
            <?php $form = ActiveForm::begin([
                'id' => 'registro-masivo-form',
            ]); ?>

            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'fecha_viernes')->textInput([
                        'type' => 'date',
                        'value' => $fechaViernes,
                        'class' => 'form-control'
                    ])->label('Fecha del Viernes') ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'monto')->textInput([
                        'type' => 'number',
                        'step' => '0.01',
                        'value' => $model::MONTO_SEMANAL,
                        'class' => 'form-control',
                        'readonly' => true
                    ])->label('Monto por Atleta ($)') ?>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label">Número de Semana</label>
                        <input type="text" class="form-control" value="<?= $numeroSemana ?>" readonly>
                        <div class="help-block">Calculado automáticamente</div>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="alert alert-warning">
                        <i class="fas fa-info-circle"></i> 
                        <strong>Información:</strong> Se registrarán aportes de <strong>$<?= number_format($model::MONTO_SEMANAL, 2) ?></strong> 
                        para cada atleta seleccionado. Solo se crearán registros nuevos si no existen aportes para la fecha especificada.
                    </div>
                </div>
            </div>

            <!-- Panel de selección de atletas -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-users"></i> Selección de Atletas
                        <span id="contador-seleccionados" class="badge badge-light ml-2">0 seleccionados</span>
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Filtros rápidos -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input type="text" id="filtro-nombre" class="form-control" placeholder="Filtrar por nombre...">
                        </div>
                        <div class="col-md-6">
                            <select id="filtro-escuela" class="form-control">
                                <option value="">Todas las escuelas</option>
                                <?php foreach (Escuela::find()->all() as $escuela): ?>
                                    <option value="<?= $escuela->id ?>"><?= Html::encode($escuela->nombre) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Controles de selección masiva -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <?= Html::button('<i class="fas fa-check-square"></i> Seleccionar Todos', [
                                'id' => 'seleccionar-todos',
                                'class' => 'btn btn-sm btn-outline-success'
                            ]) ?>
                            <?= Html::button('<i class="fas fa-square"></i> Deseleccionar Todos', [
                                'id' => 'deseleccionar-todos',
                                'class' => 'btn btn-sm btn-outline-secondary'
                            ]) ?>
                            <?= Html::button('<i class="fas fa-sync-alt"></i> Limpiar Filtros', [
                                'id' => 'limpiar-filtros',
                                'class' => 'btn btn-sm btn-outline-info'
                            ]) ?>
                        </div>
                    </div>

                    <!-- Lista de atletas -->
                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                        <table class="table table-striped table-hover" id="tabla-atletas">
                            <thead>
                                <tr>
                                    <th width="50px">
                                        <input type="checkbox" id="check-all">
                                    </th>
                                    <th>Atleta</th>
                                    <th>Escuela</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($atletas as $atleta): ?>
                                    <tr class="fila-atleta" data-id-escuela="<?= $atleta->id_escuela ?>">
                                        <td>
                                            <input type="checkbox" name="atletas[]" value="<?= $atleta->id ?>" class="check-atleta">
                                        </td>
                                        <td>
                                            <strong><?= Html::encode($atleta->p_nombre . ' ' . $atleta->p_apellido) ?></strong>
                                            <?php if (!empty($atleta->s_nombre) || !empty($atleta->s_apellido)): ?>
                                                <br><small><?= Html::encode(trim($atleta->s_nombre . ' ' . $atleta->s_apellido)) ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?= $atleta->escuela ? Html::encode($atleta->escuela->nombre) : 'N/A' ?>
                                        </td>
                                        <td>
                                            <span class="badge badge-success">Activo</span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if (empty($atletas)): ?>
                        <div class="alert alert-warning text-center">
                            <i class="fas fa-exclamation-triangle"></i> No hay atletas registrados en el sistema.
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-group mt-4">
                <?= Html::submitButton('<i class="fas fa-save"></i> Registrar Aportes Seleccionados', [
                    'class' => 'btn btn-success btn-lg',
                    'id' => 'btn-registrar',
                    'disabled' => empty($atletas)
                ]) ?>
                <?= Html::a('<i class="fas fa-times"></i> Cancelar', ['index'], ['class' => 'btn btn-default btn-lg']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<?php
// JavaScript para la interactividad
$this->registerJs(<<<JS
    $(document).ready(function() {
        // Contador de seleccionados
        function actualizarContador() {
            var seleccionados = $('.check-atleta:checked').length;
            $('#contador-seleccionados').text(seleccionados + ' seleccionados');
            $('#btn-registrar').prop('disabled', seleccionados === 0);
        }

        // Selección/deselección masiva
        $('#check-all').change(function() {
            $('.check-atleta').prop('checked', this.checked);
            actualizarContador();
        });

        $('.check-atleta').change(function() {
            actualizarContador();
            $('#check-all').prop('checked', 
                $('.check-atleta').length === $('.check-atleta:checked').length
            );
        });

        $('#seleccionar-todos').click(function() {
            $('.check-atleta').prop('checked', true);
            actualizarContador();
            $('#check-all').prop('checked', true);
        });

        $('#deseleccionar-todos').click(function() {
            $('.check-atleta').prop('checked', false);
            actualizarContador();
            $('#check-all').prop('checked', false);
        });

        // Filtros
        $('#filtro-nombre').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('#tabla-atletas tbody tr').filter(function() {
                var texto = $(this).find('td:eq(1)').text().toLowerCase();
                $(this).toggle(texto.indexOf(value) > -1);
            });
        });

        $('#filtro-escuela').change(function() {
            var escuelaId = $(this).val();
            if (escuelaId === '') {
                $('#tabla-atletas tbody tr').show();
            } else {
                $('#tabla-atletas tbody tr').hide();
                $('#tabla-atletas tbody tr[data-id-escuela="' + escuelaId + '"]').show();
            }
        });

        $('#limpiar-filtros').click(function() {
            $('#filtro-nombre').val('');
            $('#filtro-escuela').val('');
            $('#tabla-atletas tbody tr').show();
        });

        // Validación antes de enviar
        $('#registro-masivo-form').on('submit', function(e) {
            var seleccionados = $('.check-atleta:checked').length;
            if (seleccionados === 0) {
                e.preventDefault();
                alert('Por favor seleccione al menos un atleta.');
                return false;
            }
            
            if (!confirm('¿Está seguro de registrar ' + seleccionados + ' aportes semanales?')) {
                e.preventDefault();
                return false;
            }
            
            return true;
        });

        // Inicializar contador
        actualizarContador();
    });
JS
);
?>