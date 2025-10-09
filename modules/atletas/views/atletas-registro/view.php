<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Escuela;
use app\models\RegistroRepresentantes;

/** @var yii\web\View $this */
/** @var app\models\AtletasRegistro $model */
/** @var int $idEscuela */
/** @var string $nombreEscuela */

$this->title = 'Detalles del Atleta: ' . $model->p_nombre . ' ' . $model->p_apellido;
$this->params['breadcrumbs'][] = ['label' => 'Atletas Registrados', 'url' => ['index', 'id' => $idEscuela, 'nombre' => $nombreEscuela]];
$this->params['breadcrumbs'][] = $this->title;

// CSS con los colores del equipo: degradado morado-negro-cian claro
$this->registerCss(<<<CSS
    .team-gradient-bg {
        background: linear-gradient(135deg, #6a0dad, #000000, #00ffff);
        background-size: 400% 400%;
        animation: gradientShift 8s ease infinite;
        color: #000;
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.3);
        border: 2px solid #4a0072;
    }
    
    @keyframes gradientShift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    
    .team-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        border-left: 5px solid #6a0dad;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }
    
    .team-card:hover {
        transform: translateY(-5px);
    }
    
    .team-card h3 {
        color: #4a0072;
        border-bottom: 2px solid #00ffff;
        padding-bottom: 10px;
        margin-bottom: 20px;
        font-weight: bold;
    }
    
    .team-header {
        background: linear-gradient(135deg, #4a0072, #000000);
        color: white;
        padding: 30px;
        border-radius: 15px;
        margin-bottom: 30px;
        text-align: center;
        box-shadow: 0 6px 20px rgba(0,0,0,0.2);
    }
    
    .team-header h1 {
        color: #ffffff;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        margin-bottom: 10px;
        font-weight: bold;
    }
    
    .detail-view-custom .table-striped > tbody > tr:nth-of-type(odd) {
        background-color: rgba(106, 13, 173, 0.1);
    }
    
    .detail-view-custom .table-bordered {
        border: 1px solid #6a0dad;
    }
    
    .detail-view-custom .table-bordered th,
    .detail-view-custom .table-bordered td {
        border: 1px solid #6a0dad;
        padding: 12px;
    }
    
    .detail-view-custom th {
        background: linear-gradient(135deg, #6a0dad, #4a0072);
        color: white;
        font-weight: bold;
        text-align: left;
    }
    
    .detail-view-custom td {
        background-color: rgba(255, 255, 255, 0.9);
        color: #2c3e50;
    }
    
    .btn-team {
        background: linear-gradient(135deg, #6a0dad, #000000);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 25px;
        font-weight: bold;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(106, 13, 173, 0.3);
    }
    
    .btn-team:hover {
        background: linear-gradient(135deg, #4a0072, #6a0dad);
        color: #00ffff;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(106, 13, 173, 0.4);
    }
    
    .btn-team-update {
        background: linear-gradient(135deg, #00bcd4, #0097a7);
    }
    
    .btn-team-delete {
        background: linear-gradient(135deg, #e53935, #b71c1c);
    }
    
    .btn-team-back {
        background: linear-gradient(135deg, #95a5a6, #7f8c8d);
    }
    
    .info-badge {
        background: linear-gradient(135deg, #00ffff, #00bcd4);
        color: #000;
        padding: 5px 15px;
        border-radius: 20px;
        font-weight: bold;
        display: inline-block;
        margin: 5px;
    }
    
    .section-divider {
        border-bottom: 3px solid #00ffff;
        margin: 25px 0;
        opacity: 0.7;
    }
    
    .school-info {
        background: linear-gradient(135deg, #4a0072, #6a0dad);
        color: white;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
        text-align: center;
    }
CSS
);
?>

<div class="atletas-registro-view">

    <div class="team-header">
        <h1><?= Html::encode($this->title) ?></h1>
        <p class="lead" style="color: #00ffff; font-weight: bold;">
            Información detallada del atleta registrado en el sistema
        </p>
    </div>

    <!-- Información de la Escuela -->
    <?php if ($idEscuela): ?>
    <div class="school-info">
        <h4 style="margin: 0; color: #00ffff;">
            🏫 Escuela: <?= Html::encode($nombreEscuela) ?>
        </h4>
    </div>
    <?php endif; ?>

    <div class="team-gradient-bg">
        <!-- Información Personal -->
        <div class="team-card">
            <h3>📋 Información Personal</h3>
            <?= DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'table table-striped table-bordered detail-view-custom'],
                'attributes' => [
                    [
                        'attribute' => 'id',
                        'label' => 'ID Registro',
                        'contentOptions' => ['style' => 'font-weight: bold; background-color: #e8f4f8;']
                    ],
                    [
                        'attribute' => 'p_nombre',
                        'label' => 'Primer Nombre',
                    ],
                    [
                        'attribute' => 's_nombre',
                        'label' => 'Segundo Nombre',
                    ],
                    [
                        'attribute' => 'p_apellido',
                        'label' => 'Primer Apellido',
                    ],
                    [
                        'attribute' => 's_apellido',
                        'label' => 'Segundo Apellido',
                    ],
                    [
                        'attribute' => 'identificacion',
                        'label' => 'Identificación',
                        'contentOptions' => ['style' => 'font-weight: bold;']
                    ],
                    [
                        'attribute' => 'fn',
                        'label' => 'Fecha de Nacimiento',
                        'format' => ['date', 'php:d/m/Y'],
                    ],
                    [
                        'attribute' => 'sexo',
                        'label' => 'Sexo',
                        'value' => function($model) {
                            return $model->sexo == 1 ? 
                                '<span class="info-badge">👦 Masculino</span>' : 
                                '<span class="info-badge">👧 Femenino</span>';
                        },
                        'format' => 'raw',
                    ],
                ],
            ]) ?>
        </div>

        <!-- Información Física -->
        <div class="team-card">
            <h3>💪 Datos Físicos</h3>
            <?= DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'table table-striped table-bordered detail-view-custom'],
                'attributes' => [
                    [
                        'attribute' => 'estatura',
                        'label' => 'Estatura (m)',
                        'value' => function($model) {
                            return $model->estatura ? number_format($model->estatura, 2) . ' m' : 'No registrada';
                        },
                    ],
                    [
                        'attribute' => 'peso',
                        'label' => 'Peso (kg)',
                        'value' => function($model) {
                            return $model->peso ? number_format($model->peso, 2) . ' kg' : 'No registrado';
                        },
                    ],
                    [
                        'attribute' => 'talla_franela',
                        'label' => 'Talla Franela',
                        'value' => function($model) {
                            return $model->talla_franela ?: 'No especificada';
                        },
                    ],
                    [
                        'attribute' => 'talla_short',
                        'label' => 'Talla Short',
                        'value' => function($model) {
                            return $model->talla_short ?: 'No especificada';
                        },
                    ],
                    [
                        'attribute' => 'asma',
                        'label' => 'Condición de Asma',
                        'value' => function($model) {
                            return $model->asma ? 
                                '<span class="info-badge" style="background: linear-gradient(135deg, #ff9800, #f57c00);">⚠️ Sí</span>' : 
                                '<span class="info-badge" style="background: linear-gradient(135deg, #4caf50, #388e3c);">✅ No</span>';
                        },
                        'format' => 'raw',
                    ],
                ],
            ]) ?>
        </div>

        <!-- Información de Contacto -->
        <div class="team-card">
            <h3>📞 Información de Contacto</h3>
            <?= DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'table table-striped table-bordered detail-view-custom'],
                'attributes' => [
                    [
                        'attribute' => 'cell',
                        'label' => 'Teléfono Celular',
                        'value' => function($model) {
                            return $model->cell ?: 'No registrado';
                        },
                    ],
                    [
                        'attribute' => 'telf',
                        'label' => 'Teléfono Local',
                        'value' => function($model) {
                            return $model->telf ?: 'No registrado';
                        },
                    ],
                    [
                        'label' => 'Escuela/Club',
                        'value' => function($model) use ($nombreEscuela) {
                            return $nombreEscuela ?: 'No asignada';
                        },
                    ],
                ],
            ]) ?>
        </div>

        <!-- Información del Representante -->
        <div class="team-card">
            <h3>👨‍👩‍👧‍👦 Información del Representante</h3>
            <?php
            $representante = $model->id_representante ? RegistroRepresentantes::findOne($model->id_representante) : null;
            ?>
            <?= DetailView::widget([
                'model' => $representante,
                'options' => ['class' => 'table table-striped table-bordered detail-view-custom'],
                'attributes' => $representante ? [
                    [
                        'attribute' => 'p_nombre',
                        'label' => 'Primer Nombre',
                    ],
                    [
                        'attribute' => 's_nombre',
                        'label' => 'Segundo Nombre',
                    ],
                    [
                        'attribute' => 'p_apellido',
                        'label' => 'Primer Apellido',
                    ],
                    [
                        'attribute' => 's_apellido',
                        'label' => 'Segundo Apellido',
                    ],
                    [
                        'attribute' => 'identificacion',
                        'label' => 'Identificación',
                    ],
                    [
                        'attribute' => 'cell',
                        'label' => 'Teléfono Celular',
                    ],
                    [
                        'attribute' => 'telf',
                        'label' => 'Teléfono Local',
                    ],
                ] : [
                    [
                        'label' => 'Representante',
                        'value' => 'No asignado',
                        'contentOptions' => ['style' => 'color: #e74c3c; font-style: italic;']
                    ],
                ],
            ]) ?>
        </div>

        <!-- Información de Auditoría -->
        <div class="team-card">
            <h3>📊 Información de Auditoría</h3>
            <?= DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'table table-striped table-bordered detail-view-custom'],
                'attributes' => [
                    [
                        'attribute' => 'd_creacion',
                        'label' => 'Fecha de Creación',
                        'format' => ['datetime', 'php:d/m/Y H:i:s'],
                    ],
                    [
                        'attribute' => 'u_creacion',
                        'label' => 'Usuario Creación',
                    ],
                    [
                        'attribute' => 'd_update',
                        'label' => 'Última Actualización',
                        'format' => ['datetime', 'php:d/m/Y H:i:s'],
                    ],
                    [
                        'attribute' => 'u_update',
                        'label' => 'Usuario Actualización',
                    ],
                    [
                        'attribute' => 'dir_ip',
                        'label' => 'Dirección IP',
                    ],
                ],
            ]) ?>
        </div>

        <!-- Botones de Acción -->
        <div class="text-center" style="margin-top: 30px;">
            <?= Html::a('✏️ Actualizar', ['update', 'id' => $model->id], [
                'class' => 'btn btn-team btn-team-update',
                'style' => 'margin-right: 15px;'
            ]) ?>
            
            <?= Html::a('🗑️ Eliminar', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-team btn-team-delete',
                'data' => [
                    'confirm' => '¿Está seguro de que desea eliminar este atleta? Esta acción no se puede deshacer.',
                    'method' => 'post',
                ],
                'style' => 'margin-right: 15px;'
            ]) ?>
            
            <?= Html::a('📋 Volver a la Lista', ['index', 'id' => $idEscuela, 'nombre' => $nombreEscuela], [
                'class' => 'btn btn-team btn-team-back'
            ]) ?>
        </div>
    </div>

</div>

<?php
// JavaScript para mejoras interactivas
$this->registerJs(<<<JS
    // Efectos hover mejorados
    $('.team-card').hover(
        function() {
            $(this).css('transform', 'translateY(-5px)');
        },
        function() {
            $(this).css('transform', 'translateY(0)');
        }
    );
    
    // Animación para los botones
    $('.btn-team').hover(
        function() {
            $(this).css('transform', 'translateY(-2px)');
        },
        function() {
            $(this).css('transform', 'translateY(0)');
        }
    );
JS
);
?>