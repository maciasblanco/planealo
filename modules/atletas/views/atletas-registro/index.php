<?php

use app\models\AtletasRegistro;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\atletas\models\AtletasRegistroSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
$titulo= 'Atletas Registrado';;
$this->title = $titulo;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="atletas-registro-index">
    <section id="resgistroEscuelaClub">
    <center><h1><?= Html::encode($this->title).'</br>'.$nombre?></h1></center>

        <p>
            <?= Html::a('Registrar  Atletas ', ['create?id='.$id.'& nombre='.$nombre], ['class' => 'btn btn-success']) ?>
        </p>

        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                //'id',
                //'id_club',
                'id_escuela',
                //'id_representante',
                'id_alergias',
                'id_enfermedades',
                'id_discapacidad',
                'identificacion',
                'p_nombre',
                //'s_nombre',
                'p_apellido',
                //'s_apellido',
                //'id_nac',
                //'fn',
                'sexo',
                'estatura',
                'peso',
                'talla_franela',
                'talla_short',
                'cell',
                'telf',
                //'asma:boolean',
                'd_creacion',
                //'u_creacion',
                //'d_update',
                //'u_update',
                //'eliminado:boolean',
                //'dir_ip',
                [
                    'class' => ActionColumn::className(),
                    'urlCreator' => function ($action, AtletasRegistro $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    }
                ],
            ],
        ]); ?>
    </section>
</div>
