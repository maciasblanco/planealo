<?php
use app\models\Escuela;
use app\models\AtletasRegistro;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\atletas\models\AtletasRegistroSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
$titulo= 'Pagina Principal';;
$this->title = $titulo;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="atletas-registro-index">
    <section id="resgistroEscuelaClub">
    <center><h1><?= Html::encode($this->title).'</br>'.$nombre?></h1></center>

        <p>
            <a href=<?='"'.Yii::getAlias('@web').'?r=atletas/atletas-registro/create&id='.$id.'&nombre='.$nombre.'"'?> class = "btn btn-success">Regitrar Atleta</a>
        </p>

        <h1>PÁGINA EN CONSRUCCION</h1>   
    </section>
</div>
