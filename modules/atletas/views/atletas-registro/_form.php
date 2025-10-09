<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\AtletasRegistro $model */
/** @var int $id */
/** @var string $nombre */

?>

<div class="atletas-registro-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- Campo oculto para la escuela -->
    <?= $form->field($model, 'id_escuela')->hiddenInput(['value' => $id])->label(false) ?>

    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-info">
                <strong>Escuela:</strong> <?= Html::encode($nombre) ?>
            </div>
        </div>
    </div>

    <!-- Campos básicos del atleta -->
    <fieldset>
        <legend>Datos del Atleta</legend>
        <div class="row">
            <div class="col-md-3">
                <?= $form->field($model, 'p_nombre')->label('Primer Nombre')->textInput([
                    'maxlength' => true, 
                    'class' => 'form-control uppercase-field'
                ]) ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 's_nombre')->label('Segundo Nombre')->textInput([
                    'maxlength' => true, 
                    'class' => 'form-control uppercase-field'
                ]) ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'p_apellido')->label('Primer Apellido')->textInput([
                    'maxlength' => true, 
                    'class' => 'form-control uppercase-field'
                ]) ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 's_apellido')->label('Segundo Apellido')->textInput([
                    'maxlength' => true, 
                    'class' => 'form-control uppercase-field'
                ]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'identificacion')->label('Cédula/Número de Identificación')->textInput([
                    'maxlength' => true,
                    'class' => 'form-control'
                ]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'id_nac')->label('Nacionalidad')->dropDownList(
                    ['V' => 'Venezolano', 'E' => 'Extranjero'],
                    ['class' => 'form-control']
                ) ?>
            </div>
        </div>
    </fieldset>

    <!-- Campos del representante -->
    <fieldset>
        <legend>Datos del Representante</legend>
        
        <div class="row">
            <div class="col-md-3">
                <?= $form->field($model, 'p_nombre_representante')->label('Primer Nombre')->textInput([
                    'maxlength' => true, 
                    'class' => 'form-control uppercase-field'
                ]) ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 's_nombre_representante')->label('Segundo Nombre')->textInput([
                    'maxlength' => true, 
                    'class' => 'form-control uppercase-field'
                ]) ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'p_apellido_representante')->label('Primer Apellido')->textInput([
                    'maxlength' => true, 
                    'class' => 'form-control uppercase-field'
                ]) ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 's_apellido_representante')->label('Segundo Apellido')->textInput([
                    'maxlength' => true, 
                    'class' => 'form-control uppercase-field'
                ]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'identificacion_representante')->label('Cédula Representante')->textInput([
                    'maxlength' => true,
                    'class' => 'form-control'
                ]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'id_nac_representante')->label('Nacionalidad Representante')->dropDownList(
                    ['V' => 'Venezolano', 'E' => 'Extranjero'],
                    ['class' => 'form-control']
                ) ?>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'cell_representante')->label('Teléfono Celular')->textInput([
                    'maxlength' => true,
                    'class' => 'form-control'
                ]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'telf_representante')->label('Teléfono Local')->textInput([
                    'maxlength' => true,
                    'class' => 'form-control'
                ]) ?>
            </div>
        </div>
    </fieldset>

    <div class="form-group mt-3">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Cancelar', ['index', 'id' => $id, 'nombre' => $nombre], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
// JavaScript para convertir a mayúsculas en tiempo real
$this->registerJs(<<<JS
    $(document).ready(function() {
        $('.uppercase-field').on('input', function() {
            this.value = this.value.toUpperCase();
        });
        
        // Convertir valores existentes a mayúsculas
        $('.uppercase-field').each(function() {
            this.value = this.value.toUpperCase();
        });
    });
JS
);