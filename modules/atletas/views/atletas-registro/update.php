<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Escuela;

/** @var yii\web\View $this */
/** @var app\models\AtletasRegistro $model */
/** @var int $idEscuela */
/** @var string $nombreEscuela */

$this->title = 'Actualizar Atleta: ' . $model->p_nombre . ' ' . $model->p_apellido;
$this->params['breadcrumbs'][] = ['label' => 'Atletas Registrados', 'url' => ['index', 'id' => $idEscuela, 'nombre' => $nombreEscuela]];
$this->params['breadcrumbs'][] = ['label' => $model->p_nombre . ' ' . $model->p_apellido, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';

// Mismos estilos del equipo
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
    
    .form-control {
        border: 2px solid #6a0dad;
        border-radius: 8px;
        padding: 10px;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        border-color: #00ffff;
        box-shadow: 0 0 0 0.2rem rgba(0, 188, 212, 0.25);
    }
    
    .control-label {
        color: #4a0072;
        font-weight: bold;
    }
    
    .help-block {
        color: #00bcd4;
        font-style: italic;
    }
    
    .btn-team {
        background: linear-gradient(135deg, #6a0dad, #000000);
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 25px;
        font-weight: bold;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(106, 13, 173, 0.3);
        margin-right: 10px;
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
    
    .btn-team-cancel {
        background: linear-gradient(135deg, #95a5a6, #7f8c8d);
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

<div class="atletas-registro-update">

    <div class="team-header">
        <h1><?= Html::encode($this->title) ?></h1>
        <p class="lead" style="color: #00ffff; font-weight: bold;">
            Actualice la información del atleta en el sistema
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
        <div class="team-card">
            <?php $form = ActiveForm::begin(); ?>

            <h3>📋 Información Personal</h3>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'p_nombre')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 's_nombre')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'p_apellido')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 's_apellido')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'identificacion')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'fn')->textInput(['type' => 'date']) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'sexo')->dropDownList(
                        [1 => 'Masculino', 0 => 'Femenino'],
                        ['prompt' => 'Seleccione sexo...']
                    ) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'id_escuela')->dropDownList(
                        \yii\helpers\ArrayHelper::map(Escuela::find()->all(), 'id', 'nombre'),
                        ['prompt' => 'Seleccione escuela...']
                    ) ?>
                </div>
            </div>

            <h3>💪 Datos Físicos</h3>
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'estatura')->textInput(['type' => 'number', 'step' => '0.01']) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'peso')->textInput(['type' => 'number', 'step' => '0.01']) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'asma')->checkbox() ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'talla_franela')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'talla_short')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <h3>📞 Información de Contacto</h3>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'cell')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'telf')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="form-group text-center" style="margin-top: 30px;">
                <?= Html::submitButton('💾 Guardar Cambios', ['class' => 'btn btn-team btn-team-update']) ?>
                <?= Html::a('❌ Cancelar', ['index', 'id' => $idEscuela, 'nombre' => $nombreEscuela], ['class' => 'btn btn-team btn-team-cancel']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
<?php
// JavaScript para convertir a mayúsculas en tiempo real
$this->registerJs(<<<JS
    // Función para convertir a mayúsculas
    function convertToUpperCase(element) {
        element.value = element.value.toUpperCase();
    }

    // Aplicar a todos los campos de texto excepto contraseñas y emails
    $('input[type="text"]:not(.no-uppercase), textarea:not(.no-uppercase)').on('input', function() {
        convertToUpperCase(this);
    });

    // También aplicar cuando el campo pierde el foco (por si acaso)
    $('input[type="text"]:not(.no-uppercase), textarea:not(.no-uppercase)').on('blur', function() {
        convertToUpperCase(this);
    });

    // Para campos específicos que podrían no ser type="text"
    $('#atletasregistro-p_nombre, #atletasregistro-s_nombre, #atletasregistro-p_apellido, #atletasregistro-s_apellido').on('input blur', function() {
        convertToUpperCase(this);
    });

    $('#atletasregistro-identificacion, #atletasregistro-cell, #atletasregistro-telf').on('input blur', function() {
        convertToUpperCase(this);
    });

    $('#atletasregistro-talla_franela, #atletasregistro-talla_short').on('input blur', function() {
        convertToUpperCase(this);
    });

    // Campos del representante
    $('#atletasregistro-p_nombre_representante, #atletasregistro-s_nombre_representante').on('input blur', function() {
        convertToUpperCase(this);
    });

    $('#atletasregistro-p_apellido_representante, #atletasregistro-s_apellido_representante').on('input blur', function() {
        convertToUpperCase(this);
    });

    $('#atletasregistro-identificacion_representante, #atletasregistro-cell_representante, #atletasregistro-telf_representante').on('input blur', function() {
        convertToUpperCase(this);
    });
JS
);
?>