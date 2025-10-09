<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);
//Select2 configuration
\app\assets\Select2BootstrapAsset::register($this);
\app\assets\Select2LoadAsset::register($this);
$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">

<?php $this->beginBody() ?>
<header id="header">
    <!--Seleccionar Imagen del  y fondos del Banner de cada escuela-->

    <?php
        /*Selecciono el valor de la escuela por el metodo get*/
        $codeEscuela = (int)Yii::$app->request->get('id', 0);
        $codeNombreEscuela = Yii::$app->request->get('nombre', '');
        
        // Validar que el logo existe, si no usar uno por defecto
        $logoFile = 'logo' . $codeEscuela . '.png';
        $logoPath = Yii::getAlias('@webroot') . '/img/logos/escuelas/' . $logoFile;
        $dirLogo = file_exists($logoPath) ? 
            '/img/logos/escuelas/logo' . $codeEscuela . '.png' : 
            '/img/logos/escuelas/default.png';
            
        NavBar::begin([
            'brandLabel' => '<img src="' . Yii::getAlias('@web') . $dirLogo . '" class="d-block img-logo" alt="Logo Escuela" style="height: 40px;">',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top']
        ]);
    ?>
    
    <?php 
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav scrollto'],
            'items' => [
                ['label' => 'Inicio', 'url' => ['/site/index']],
                [
                    'label' => 'Registros',
                    'items' => [
                        ['label' => 'Atletas', 'url' => ['/atletas/atletas-registro/index', 'id' => $codeEscuela, 'nombre' => $codeNombreEscuela]]
                    ],
                ],
                [
                    'label' => 'G.E.D',
                    'items' => [
                        ['label' => 'Escuelas Registradas', 'url' => ['/#escuelas']],
                        ['label' => 'Acerca de...', 'url' => ['/#Acerca_de']],
                        ['label' => 'Contact', 'url' => ['/site/contact']],
                    ],
                ],
                ['label' => 'Aportes', 'url' => ['/aportes/index']],
                Yii::$app->user->isGuest
                    ? ['label' => 'Login', 'url' => ['/site/login']]
                    : '<li class="nav-item">'
                        . Html::beginForm(['/site/logout'])
                        . Html::submitButton(
                            'Logout (' . Yii::$app->user->identity->username . ')',
                            ['class' => 'nav-link btn btn-link logout']
                        )
                        . Html::endForm()
                        . '</li>'
            ]
        ]);
    ?>
    
    <!-- Panel de Redes Sociales -->
    <div class="navbar-text panel-redes-sociales ms-3">
        <div id="icons-redes-sociales" class="social-links">
            <h6 class="mb-1">Redes Sociales</h6>
            <a href="#" class="twitter me-2"><i class="bi bi-twitter"></i></a>
            <a href="#" class="facebook me-2"><i class="bi bi-facebook"></i></a>
            <a href="@lacasadelastogasccs" class="instagram me-2"><i class="bi bi-instagram"></i></a>
            <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
        </div>
    </div>

    <!-- Panel de Noticias -->
    <div class="navbar-text panel-Noticias ms-3">
        <h6 class="mb-1">Noticias</h6> 
        <div id="carrusel-nav" class="carousel-nav-container">
            <div id="carouselNav" class="carousel slide carousel-fade" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselNav" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselNav" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselNav" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="<?= Yii::getAlias('@web') ?>/img/nav_carousel/categorias.png" class="d-block w-100" alt="Categorias">
                    </div>
                    <div class="carousel-item">
                        <img src="<?= Yii::getAlias('@web') ?>/img/nav_carousel/JuegosDistritales_Entrenar.png" class="d-block w-100" alt="Juegos Distritales">
                    </div>
                    <div class="carousel-item">
                        <img src="<?= Yii::getAlias('@web') ?>/img/nav_carousel/imgMotiva.png" class="d-block w-100" alt="Motivación">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselNav" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselNav" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Siguiente</span>
                </button>
            </div>
        </div>    
    </div>

    <?php NavBar::end(); ?>
</header>

<main id="main" class="flex-shrink-0 mt-5 margen-main" role="main">
    <div class="container">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    </div>
</main>

<footer id="footer" class="mt-auto py-3 bg-light">
    <div class="container">
        <div class="row text-muted">
            <div class="col-md-6 text-center text-md-start">&copy; My Company <?= date('Y') ?></div>
            <div class="col-md-6 text-center text-md-end"><?= Yii::powered() ?></div>
        </div>
    </div>
</footer>

<?php
    $this->registerJs(<<<JAVASCRIPT
        $(document).ready(function(){
            let divCarousel = document.querySelector('#carrusel-nav');
            $('#carouselNav').carousel({
                interval: 4000
            });
        });
    JAVASCRIPT
    );
?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>