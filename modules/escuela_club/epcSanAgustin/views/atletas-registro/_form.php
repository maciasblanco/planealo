<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\AtletasRegistro $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="row">
<?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-5 animated">
            <img src=<?='"'.Yii::getAlias('@web').'/img/escuela/voleibol/img/voleibol1.jpg'.'"'?> class="img-registro"alt="...">
        </div>
        <div class="col-md-7">
            <h1>Datos Representantes</h1>
            <h5 class="title">Voleibol</h5>
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'p_nombre_representante')->textInput() ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 's_nombre_representante')->textInput() ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'p_apellido_representante')->textInput() ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 's_apellido_representante')->textInput() ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'id_nac_representante')->textInput() ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'identificacion_representante')->textInput() ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'cell_representante')->textInput() ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'telf_representante')->textInput() ?>
                </div>
            </div>
            <div class="row">
                <div class="row">
                    <div class="col-md-3">
                        <?= $form->field($model, 'id_club')->textInput() ?>
                    </div>
                    <div class="col-md-3">
                        <?= $form->field($model, 'id_escuela')->textInput() ?>
                    </div>
                    <div class="col-md-3">
                        <?= $form->field($model, 'id_representante')->textInput() ?>
                    </div>
                    <div class="col-md-3">
                        <?= $form->field($model, 'id_alergias')->textInput() ?>
                    </div>
                    <div class="col-md-3">
                        <?= $form->field($model, 'id_enfermedades')->textInput() ?>
                    </div>
                    <div class="col-md-3">
                        <?= $form->field($model, 'id_discapacidad')->textInput() ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <?= $form->field($model, 'p_nombre')->textInput() ?>
                    </div>
                    <div class="col-md-3">
                        <?= $form->field($model, 's_nombre')->textInput() ?>
                    </div>
                    <div class="col-md-3">
                        <?= $form->field($model, 'p_apellido')->textInput() ?>
                    </div>
                    <div class="col-md-3">
                        <?= $form->field($model, 's_apellio')->textInput() ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <?= $form->field($model, 'id_nac')->textInput() ?>
                    </div>
                    <div class="col-md-3">
                        <?= $form->field($model, 'identificacion')->textInput() ?>
                    </div>
                    <div class="col-md-3">
                        <?= $form->field($model, 'fn')->textInput() ?>
                    </div>
                    <div class="col-md-3">
                        <?= $form->field($model, 'sexo')->textInput() ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <?= $form->field($model, 'estatura')->textInput() ?>
                    </div>
                    <div class="col-md-3">
                        <?= $form->field($model, 'peso')->textInput() ?>
                    </div>
                    <div class="col-md-3">
                        <?= $form->field($model, 'talla_franela')->textInput() ?>
                    </div>
                    <div class="col-md-3">
                        <?= $form->field($model, 'talla_short')->textInput() ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <?= $form->field($model, 'cell')->textInput() ?>
                    </div>
                    <div class="col-md-3">
                        <?= $form->field($model, 'telf')->textInput() ?>
                    </div>
                    <div class="col-md-3">
                        <?= $form->field($model, 'asma')->checkbox() ?>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>

    </div>
<?php ActiveForm::end(); ?>
</div>
