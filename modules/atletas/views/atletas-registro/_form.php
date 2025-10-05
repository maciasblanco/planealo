<?php

use app\models\Discapacidad;
use app\models\Enfermedades;
use app\models\Nacionalidad;
use app\models\Sexo;
use app\models\Alergias;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\AtletasRegistro $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="container-registro-atletas-form">
    <section id="resgistroAtletas">
        <div class="row">
            <div class="section-title">
                <h2>Registro Atletas</h2>
            </div> 
        </div>
<<<<<<< HEAD
        <?php $form = ActiveForm::begin([
                    'enableAjaxValidation' => true,
                    'validateOnBlur' => true,
                    'validateOnChange' => true,
                ]); ?> 

=======
        <?php $form = ActiveForm::begin(); ?> 
>>>>>>> origin/mjbv-oficina
            <div id="form-ingresoAtleta" class="row">
                <div class="col-md-4 animated">
                    <img src=<?='"'.Yii::getAlias('@web').'/img/escuela/voleibol/img/voleibol1.jpg'.'"'?> class="img-registro"alt="..."> 
                </div>
                <div class="col-md-8">
                    <div class="section-title">
                        <h2 class="title">Voleibol </h2><?=$nombre?>
                    </div>
                    <div class="row">
                        <div class="section-title">
                            <h3>Datos Representantes</h3>
                        </div>
                        <div class="col-md-3">
                            <?= $form->field($model, 'p_nombre_representante')->label('Primer Nombre')->textInput() ?>
                        </div>
                        <div class="col-md-3">
                            <?= $form->field($model, 's_nombre_representante')->label('Segundo Nombre')->textInput() ?>
                        </div>
                        <div class="col-md-3">
                            <?= $form->field($model, 'p_apellido_representante')->label('Primer Apellido')->textInput() ?>
                        </div>
                        <div class="col-md-3">
                            <?= $form->field($model, 's_apellido_representante')->label('Segundo Apellido')->textInput() ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <?= $form->field($model, 'id_nac_representante')->dropDownList(ArrayHelper::map(Nacionalidad::find()->orderby('id')->all(), 'id', 'letra'),[
                                'prompt' => '',
                                'id'=>'nac',
                                'class' => 'form-control',
                            ])->label('Nac.'); ?>
                        </div>
                        <div class="col-md-3">
                            <?= $form->field($model, 'identificacion_representante')->label('Cédula')->textInput() ?>
                        </div>
                        <div class="col-md-3">
                            <?= $form->field($model, 'cell_representante')->label('Teléfono Celular')->textInput() ?>
                        </div>
                        <div class="col-md-3">
                            <?= $form->field($model, 'telf_representante')->label('Teléfono Local')->textInput() ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="section-title">
                            <h3>Datos Atletas</h3>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <?= $form->field($model, 'p_nombre')->textInput()->label('Primer Nombre') ?>
                            </div>
                            <div class="col-md-3">
                                <?= $form->field($model, 's_nombre')->textInput()->label('Segundo Nombre') ?>
                            </div>
                            <div class="col-md-3">
                                <?= $form->field($model, 'p_apellido')->textInput()->label('Primer Apellido') ?>
                            </div>
                            <div class="col-md-3">
                                <?= $form->field($model, 's_apellido')->textInput()->label('Segundo Apellido') ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <?= $form->field($model, 'id_nac')->dropDownList(ArrayHelper::map(Nacionalidad::find()->orderby('id')->all(), 'id', 'letra'),[
                                    'prompt' => '',
                                    'id'=>'nac',
                                    'class' => 'form-control',
                                ])->label('Nac.'); ?>
                            </div>
                            <div class="col-md-3">
<<<<<<< HEAD
                                <?= $form->field($model, 'identificacion')->textInput([
                                    'maxlength' => true,
                                    'placeholder' => 'Ingrese el número de identificación',
                                ])->label('Cédula') ?>
=======
                                <?= $form->field($model, 'identificacion')->textInput()->label('Cédula') ?>
>>>>>>> origin/mjbv-oficina
                            </div>
                            <div class="col-md-3">
                                <?= $form->field($model, 'fn')->textInput([
                                    'id'=>'fn',
                                    'type'=>'date',

                                ])->label('Fecha Nacimiento') ?>
                            </div>
                            <div class="col-md-2">
                                <?= $form->field($model, 'categoria')->textInput([
                                    'id'=>'categoria',
                                ])->label('Categoria'); ?>
                            </div>
                            <div class="col-md-2">
                                <?= $form->field($model, 'sexo')->dropDownList(ArrayHelper::map(Sexo::find()->orderby('id')->all(), 'id', 'descripcion'),[
                                    'prompt' => '',
                                    'id'=>'nac',
                                    'class' => 'form-control',
                                ])->label('Sexo'); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <?= $form->field($model, 'estatura')->textInput()->label('Estatura en mts.') ?>
                            </div>
                            <div class="col-md-3">
                                <?= $form->field($model, 'peso')->textInput()->label('Peso en Kgs') ?>
                            </div>
                            <div class="col-md-3">
                                <?= $form->field($model, 'talla_franela')->textInput()->label('Talla Franela') ?>
                            </div>
                            <div class="col-md-3">
                                <?= $form->field($model, 'talla_short')->textInput()->label('Talla Short') ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <?= $form->field($model, 'cell')->textInput()->label('Teléfono Celular') ?>
                            </div>
                            <div class="col-md-3">
                                <?= $form->field($model, 'telf')->textInput()->label('Teléfono Casa') ?>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-md-4">
                                <?= $form->field($model, 'id_escuela')->textInput([
                                    'id'=>'idEscuela',
                                    'value'=>$id,
                                ])->label('Id.Escuela/Club Deportivo') ?>
                            </div>
                            <div class="col-md-8">
                                <?= $form->field($model, 'nombreEscuelaClub')->textInput([
                                    'id'=>'idEscuela',
                                    'value'=>$nombre,
                                ])->label('Nombre Escuela/Club Deportivo que Pertenece') ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <?= $form->field($model, 'id_alergias')->dropDownList(ArrayHelper::map(Alergias::find()->orderby('id')->all(), 'id', 'descripcion'),
                                    ['prompt' => '',
                                    'id'=>'enfermedades',
                                    'class' => 'form-control',
                                    ])->label('Alergias'); ?>
                                </div>
                            <div class="col-md-4">
                                <?= $form->field($model, 'id_enfermedades')->dropDownList(ArrayHelper::map(Enfermedades::find()->orderby('id')->all(), 'id', 'descripcion'),
                                ['prompt' => '',
                                'id'=>'enfermedades',
                                'class' => 'form-control',
                                ])->label('Enfermedades Cronicas'); ?>
                            </div>
                            <div class="col-md-4">
                                <?= $form->field($model, 'id_discapacidad')->dropDownList(ArrayHelper::map(Discapacidad::find()->orderby('id')->all(), 'id', 'descripcion'),
                                ['prompt' => '',
                                'id'=>'discapacidad',
                                'class' => 'form-control',
                                ])->label('Discapacidad'); ?>

                            </div>
                        </div>
                        <div class="row">
                            <div class="section-title">
                                <h3>Telefonos de Contacto Caso de Emergencia</h3>
                            </div>
                            <div class="col-md-3">
                                <?= $form->field($model, 'cell')->textInput()->label('Telf 1')->label('Teléfono Contacto 1') ?>
                            </div>
                            <div class="col-md-3">
                                <?= $form->field($model, 'telf')->textInput()->label('Telf 2')->label('Teléfono Contacto 2') ?>
                            </div>
                        </div>
                    </div>
                </div>            
            </div>
            <div class="row">
                <div class="col-md-4 offset-md-4">
                    <div class="form-group">
                        <?= Html::submitButton('Guardar Registro Atleta', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
            </div> 
        <?php ActiveForm::end(); ?>                      
    </section>
<script type="text/javascript">
    $('#fn').on('blur', function(){
        var annioIncioSistema=2025;
        let tiempoTranscurrido=Date.now();
        const anioHoy = new Date(tiempoTranscurrido);
        let aniosTrascurridos=annioIncioSistema-anioHoy
        var fechaNac=new Date($('#fn').val());
        let annioNac= parseInt(fechaNac.getUTCFullYear());
        console.log (annioNac); 
        //verifico cuantos años an pasado desde el incion del sistema

        console.log ('el año actual es '+anioHoy.getUTCFullYear());
        switch (true) {
            case annioNac > 2004 && annioNac < 2007 : //años 2005-2006:
                console.log("Juvenil");
                $('#categoria').val("Juvenil");
                break;
            case annioNac > 2006 && annioNac < 2009: //años 2007-2008:
                console.log("Pre-Juvenil");
                $('#categoria').val("Pre-Juvenil");
                break  
            case annioNac > 2008 && annioNac < 2011: //años 2009-2010:
                console.log("Infantil");
                $('#categoria').val("Infantil");
                break  
            case annioNac > 2010 && annioNac < 2013: //años 2011-2012:
                console.log("Minivol");
                $('#categoria').val("Minivol");
                break
            case annioNac > 2012 && annioNac < 2015: //años 2013-2014:
                console.log("Semillita");
                $('#categoria').val("Semillita");
                break
            case annioNac > 2014 && annioNac < 2017: //años 2015-2016:
                console.log("Pre-Semillita");
                $('#categoria').val("Pre-Semillita");
                break
            default:
                console.log("Libre o Master");
                break;
        }
    });
</script>   
</div>
    