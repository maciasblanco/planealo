<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\AtletasRegistro $model */

$this->title = 'Registro de Atletas';
$this->params['breadcrumbs'][] = ['label' => 'Registro de Atletas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="atletas-registro-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model' => $model,            
        'id' => $id, 
        'nombre' => $nombre,
    ]) ?>

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