<?php

use app\models\Escuela;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\epcSanAgustin\atletas\models\EscuelaRegistroSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Escuelas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="escuela-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Escuela', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_estado',
            'id_municipio',
            'id_parroquia',
            'direccion_administrativa',
            //'direccion_practicas',
            //'lat',
            //'lng',
            //'nombre',
            //'d_creacion',
            //'u_creacion',
            //'d_update',
            //'u_update',
            //'eliminado:boolean',
            //'dir_ip',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Escuela $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
