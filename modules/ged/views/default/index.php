<?php

use yii\helpers\Html;

/** @var yii\web\View $this */

$this->title = 'Gestión Escuelas Deportivas';
?>
<div class="site-index">
    <section id="Carrusel-Promocional">
        <div class="row">
            <div class="section-title">
                <h2>Gestión Escuelas Deportivas</h2>
            </div> 
            <div class="registro-escuelas-deportiva col-md-4">
                <div id="div_imagen">

                </div>
                <div  class="registro-escuela">
                    <h1>Registra tu escuela deportiva
                        <div class="tooltip">
                            <span class="tooltiptext">Aqui se puedes registar la Escuela/Club deportivo</span>
                        </div>
                    </h1>
                    <div class="card col-md-12">
                        <video src=<?='"'.Yii::getAlias('@web').'/img/videos/propaganda_ged_1.mp4'.'"'?> autoplay muted loop width="100%"></video>
                        <div class="card-body">
                            <h5 class="card-title">Registrate</h5>
                            <p class="card-text">Ten control de la estadistica de los atletas, la getion administrativa de tu escuela y más
                                <?= Html::a('Regitrar Escuela/Club Deportivo', ['/escuela_club/escuela-registro/create'], ['class' => 'btn btn-success']) ?>
                            </p>
                        </div>
                    </div> 
                </div>
            </div>
            <div id="carrusel-principal" class="col-md-8">
                <div id="carouselIndexGed" class="carousel slide carousel-fade" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselIndexGed" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselIndexGed" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselIndexGed" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src=<?='"'.Yii::getAlias('@web').'/img/escuela/voleibol/img/voleibol1.jpg'.'"'?> class="d-block w-100" alt="...">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Escuela de Voleibol</h5>
                                <p>Entrenamiento, tecnica, agilidad en este disciplina</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src=<?='"'.Yii::getAlias('@web').'/img/escuela/basketbol/img/basketbol.jpg'.'"'?> class="d-block w-100" alt="...">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Escuela de Basketbol</h5>
                                <p>Entrenamiento, tecnica, agilidad en este disciplina</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src=<?='"'.Yii::getAlias('@web').'/img/escuela/futbol/img/futbol.jpeg'.'"'?> class="d-block w-100" alt="...">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Escuela de Futbol</h5>
                                <p>Entrenamiento, tecnica, agilidad en este disciplina</p>
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselIndexGed" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Anterior</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselIndexGed" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Siguiente</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    </section>

    <section id="escuelas" class="section-title">
        <div class="row">
            <h2>Escuelas/Club Deportivos Registrados</h2>
            <?php
                foreach ($datosEscuelas as $data){ ?>
                <div class="card col-md-4">
                    <a href=<?='"'.Yii::getAlias('@web').'/ged?id='.$data['id'].'& nombre='.$data['nombre'].'"'?>><img src=<?='"'.Yii::getAlias('@web').'/img/logos/escuelas/logo'.$data['id'].'.png'.'"'?> class="card-img-top" alt="voleibol"></a>
                    <div class="card-body">
                        <h5 class="card-title"><?=$data['nombre'] ?></h5>
                        <p class="card-text">Enseñanza de los fundamentos básicos del Voleibol, Basketbol, Futbol, posicionamiento en cancha y tactica de juego para cada deporte </p>
                        <p>
                        <a href=<?='"'.Yii::getAlias('@web').'?r=atletas/atletas-registro/create&id='.$data['id'].'& nombre='.$data['nombre'].'"'?> class = "btn btn-success">Regitrar Atleta</a>
                        <!-- <?= Html::a('Regitrar Atleta', ['/atletas/atletas-registro/create&id='.$data['id'].'& nombre='.$data['nombre']], ['class' => 'btn btn-success']) ?>-->
                        </p>
                    </div>
                </div>
                <?php } ?>  
        </div>
    </section>
    <!-- ======= About Us Section ======= -->
    <section id="Acerca_de" class="about">
      <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>Acerca de G.E.D</h2>
            </div>

            <div class="col-lg-12" data-aos="fade-up" data-aos-delay="150">
                <div class="section-sub-title">
                    <h2>HISTORIA</h2>
                </div>
                <p>
                    El sistema nace en el añon 2025, al detectarse la necesidad de llevar información de atletas en edades 
                    comprendidas entre 8 y 21 años y observarse que no existen sistemas de fabricación nacacional con tecnología 
                    nacional que nos de seguridad en datos y con indepencia tecnológica.
                </p>
            </div>
            <div class="row content">
                <div class="section-sub-title col-lg-6" data-aos="fade-up" data-aos-delay="150">
                    <h2>MISIÓN</h2>
                        <p>
                        Ofrecer espacios informatico donde las Escuelas Deportivas y Clubes Deportivos puedan llevar 
                        la gestión Administrativo; además de la gestión de Atletas, Estadisticas y tiempo de uso Espacios Deportivos,   .
                        </p>
                </div>
                <div class="section-sub-title col-lg-6 pt-4 pt-lg-0" data-aos="fade-up" data-aos-delay="300">
                    <h2>VISIÓN</h2>
                        <p>
                            Registar a la mayor cantidad de Escuelas y Clubes deportivos para hacer un cambio y mejora tecnológica; siendo una referencia Nacional e Internacional 
                        </p>
                        <!--<a href="#" class="btn-learn-more">Learn More</a>-->
                </div>
            </div>
        </div>
    </section><!-- End About Us Section -->
    <section id="Ubicacion">
        
    </section>
<?php
    $this->registerJs(<<<JAVASCRIPT
        $( document ).ready(function(){
            $('#carouselIndexGed').carousel({
            interval: 2000
            });
        });
    JAVASCRIPT
    );
?>
</div>
