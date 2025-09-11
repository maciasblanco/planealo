<?php


use app\models\Estado;
use app\models\Municipio;
use app\models\Parroquia;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

\app\assets\MapasDinamicosAsset::register($this);
/** @var yii\web\View $this */
/** @var app\models\Escuela $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="escuela-form">
    <section id="resgistroEscuelaClub">
        <div class="row">
            <div class="section-title">
                <h2>Gestión Escuelas Deportivas - Registro Escuela/Club</h2>
            </div> 
            <?php $form = ActiveForm::begin(); ?>
            <div id="geolocalizacion" class="geolocalizacion col-md-12">
                <div class="row">
                    <div class="col-md-3">
                        <div class="col-md">
                            <?= $form->field($model, 'id_estado')->dropDownList(ArrayHelper::map(Estado::find()->orderby('id')->all(), 'id', 'estado'),[
                                'prompt' => '',
                                'id'=>'estado',
                                'class' => 'form-control has-dependent-dropdown',
                                'data-dependent' => [
                                    'municipio' => [
                                        'url' => Yii::$app->urlManager->createUrl(['/municipio/get-by-edo']),
                                        'data' => ["edo" => "this"],
                                        'destiny' => 'municipio',
                                    ],
                                ],
                            ])->label('Estado'); ?>
                        </div>
                        <div class="col-md">
                            <?= $form->field($model, 'id_municipio')->dropDownList(empty($model->id_municipio) ? [] : [$model->id_municipio => $model->municipio->municipio] ,[
                                'prompt' => '',
                                'id'=>'municipio',
                                'class' => 'form-control has-dependent-dropdown',
                                'data-dependent' => [
                                    'parroquia' => [
                                        'url' => Yii::$app->urlManager->createUrl(['/parroquia/get-by-muni']),
                                        'data' => ["muni" => "this"],
                                        'destiny' => 'parroquia',
                                    ]
                                ]
                            ])->label('Municipio'); ?>
                        </div>
                        <div class="col-md">
                            <?= $form->field($model, 'id_parroquia')->dropDownList(empty($model->id_parroquia) ? [] : [$model->id_parroquia => $model->parroquia->parroquia], [
                                'prompt' => '',
                                'id'=>'parroquia',
                                'class' => 'form-control has-dependent-dropdown',

                            ])->label('Parroquia'); ?>

                        </div>
                        <div class="col-md">
                            <?= $form->field($model, 'lat')->textInput() ?>
                        </div>
                        <div class="col-md"> 
                            <?= $form->field($model, 'lng')->textInput() ?>
                        </div>
                    </div>

                    <div id="mapa" class="col-md-9">
                    <!--Dato del Mapa-->
                    </div>
                </div>
            </div>  
                </div>
            </div>
            <?= $form->field($model, 'direccion_administrativa')->textInput() ?>

            <?= $form->field($model, 'direccion_practicas')->textInput() ?>
              
            <?= $form->field($model, 'nombre')->textInput() ?>
            <div class="row">
                <div class="col-md-6">
                    <?php if ($model->isNewRecord) {?>
                        <div class="row">
                            <div class="col-md-5">
                                <h3>Logo</h3>
                                <div class="drop-area">
                                    <h5>Arrastra y suelta la Imagen</h5>
                                    <span>O</span>
                                    <div id="boton" class="btn-primary-ged" >Selecciona el archivo</div>
                                    <input
                                        type="file" 
                                        name="" 
                                        accept="image/*" 
                                        id="input-file" 
                                        hidden="true" 
                                        multiple>
                                    <div class="col-md-8">
                                        <?= $form->field($model, 'existImage')->textInput(['id'=>'existImage','hidden'=>true])->label("") ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <h3>Vista Previa</h3>
                                <div class="container-img ">
                                    <div id="preview">
                                </div>
                            </div>
                        </div>
                    <?php };?>
                </div>
            </div>
            
            <div class="col-md-6">
                <?php
                    if (!$model->isNewRecord) {
                        echo $form->field($model, 'eliminado')->checkbox();
                    }
                ?>
            </div>
            <div class="row">
                <div class="form-group">
                    <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<script src=<?='"'.Yii::getAlias('@web')."/js/leaflet/leaflet.js".'"'?> integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
<script type="text/javascript">
    var puntoCentral =[10.493983728490193, -66.90855519885437];
    var map = L.map("mapa").setView(puntoCentral,17);
    var originalMap = L.tileLayer("http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png").addTo(map);
    'Capturo la coordedas selecciona por el usuario'
    function capturaCoordenadas(event){
        console.log(event)
        $("#lat").val(event.latlng.lat);
        $("#long").val(event.latlng.lng);
    };
    map.on("click",capturaCoordenadas);
</script>