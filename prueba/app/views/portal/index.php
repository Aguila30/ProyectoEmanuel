<?php
session_start();
if (!isset($_SESSION["is_logged"]) || $_SESSION["is_logged"] == false) {
    header("location: ../../../index.php?error=Debes iniciar sesión&type=warning");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MTV Awards 2025 | Inicio</title>
    
    <link rel="stylesheet" href="../../../recursos/recursos_panel/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../../recursos/recursos_panel/css/adminlte.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../../../recursos/recursos_portal/css/portal.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-mtv fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="../../../recursos/img/system/mtv-logo.jpg" width="50" height="50" alt="MTV Logo" style="border-radius: 5px;">
                <span class="mtv-font ml-2" style="font-size: 1.5rem;">MTV AWARDS</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto align-items-center">
                    <li class="nav-item active">
                        <a class="nav-link text-warning" href="#">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="categorias.php">Categorías</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="mis_votos.php">Mis Votos</a>
                    </li>
                    <li class="nav-item dropdown ml-3">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown">
                            <img src="../../../recursos/img/users/<?= $_SESSION['img'] ?>" class="rounded-circle" width="35" height="35" alt="User">
                            <span class="ml-2"><?= $_SESSION['nickname'] ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right bg-dark border-warning">
                            <a class="dropdown-item text-white" href="#"><i class="fas fa-user mr-2"></i> Mi Perfil</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="../../backend/panel/liberate_user.php"><i class="fas fa-power-off mr-2"></i> Cerrar Sesión</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="hero-section">
        <div class="hero-content container">
            <span class="badge badge-warning mb-3" style="font-size: 1.2rem;">EDICIÓN 2025</span>
            <h1>¿Que son los  <br> MTVawards? &#128559;</h1>
            <p class="lead mb-5" style="text-align: justify"    >Los MTV Awards, oficialmente llamados MTV Video Music Awards (VMAs), 
                son una de las premiaciones más importantes de la industria musical a nivel mundial. Fueron creados en 1984 por el canal de televisión MTV (Music Television)
con el objetivo de reconocer a los mejores videos musicales del año.

Estos premios destacan por su estilo moderno, juvenil y atrevido, convirtiéndose
 en un evento que no solo celebra la música, sino también la cultura pop, la moda y las tendencias globales. 
 A diferencia de otros premios tradicionales, los MTV Awards son famosos por sus presentaciones en vivo, momentos inesperados, 
discursos virales y shows espectaculares.

Los VMAs otorgan reconocimientos en categorías como:

Video del Año

Artista del Año

Mejor Canción

Mejor Colaboración

Mejor Video Pop, Rock, Hip-Hop, entre otros <br>¡La votación está abierta!</p>
            <a href="https://es.wikipedia.org/wiki/MTV_Video_Music_Awards" class="btn btn-mtv">
                Ver mas sobre su historia   <i class="fas fa-bolt ml-2"></i>
            </a>
        </div>
    </header>

    <section class="container my-5 py-5">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2 class="section-title text-warning">LOS PREMIOS <br>MÁS SALVAJES</h2>
                <p style="font-size: 1.1rem; line-height: 1.8;">
                    Los <strong>MTV Awards</strong> no son una premiación cualquiera. Son el reconocimiento global a la rebeldía, 
                    la creatividad y el impacto cultural.
                    <br><br>
                    Aquí no deciden los críticos. <strong>DECIDES TÚ.</strong>
                </p>
            </div>
            <div class="col-md-6 text-center">
                <img src="../../../recursos/img/system/album.png" alt="Moonman Trophy" class="img-fluid" style="max-height: 400px; filter: drop-shadow(0 0 10px #FFFF00);">
            </div>
        </div>
    </section>

    <section class="container mb-5">
        <h2 class="section-title">EN TENDENCIA <span class="text-muted" style="font-size: 1.5rem;"> Lo Mas Exclusivo</span></h2>
        
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card card-trend h-100">
                    <img src="../../../recursos/img/artistas/badbunny.jpg" class="card-img-top" alt="Bad Bunny">
                    <div class="card-body">
                        <span class="badge badge-warning">ARTISTA</span>
                        <h4 class="card-title mt-2 mtv-font">Bad Bunny</h4>
                        <p class="card-text text-muted">Dominando las listas globales con 5 nominaciones.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card card-trend h-100">
                    <img src="../../../recursos/img/album/vida_una.jpg" class="card-img-top" alt="Album">
                    <div class="card-body">
                        <span class="badge badge-info">ÁLBUM</span>
                        <h4 class="card-title mt-2 mtv-font">Mañana Será Bonito</h4>
                        <p class="card-text text-muted">Karol G rompe récords históricos este año.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card card-trend h-100">
                    <div style="height: 250px; background-color: #333; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-crown fa-5x text-warning"></i>
                    </div>
                    <div class="card-body">
                        <span class="badge badge-danger">Categoria reñida</span>
                        <h4 class="card-title mt-2 mtv-font">Mejor Artista Nuevo</h4>
                        <p class="card-text text-muted">Peso Pluma vs. Young Miko.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="votar" class="vote-banner text-center">
        <div class="container">
            <h2 class="display-3 mtv-font font-weight-bold">Tienes el poder</h2>
            <p class="h4 mb-4 font-weight-light">La votación cierra <strong>... </strong>.</p>
            <div class="bg-black d-inline-block p-3 rounded mb-4">
                <h1 class="text-white m-0" id="contador">00 : 00 : 00 : 00</h1>
                <small class="text-muted">DÍAS : HRS : MIN : SEG</small>
            </div>
            <br>
            <a href="categorias.php" class="btn btn-outline-dark btn-lg font-weight-bold border-2">
                VER TODAS LAS CATEGORÍAS
            </a>
        </div>
    </section>

    <footer class="bg-black py-4 text-center border-top border-secondary mt-5">
        <p class="text-muted m-0">MTV Awards System © 2025.</p>
    </footer>

    <script src="../../../recursos/recursos_panel/plugins/jquery/jquery.min.js"></script>
    <script src="../../../recursos/recursos_panel/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Cuenta regresiva
        var countDownDate = new Date("Jun 30, 2025 23:59:59").getTime();
        var x = setInterval(function() {
            var now = new Date().getTime();
            var distance = countDownDate - now;
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            document.getElementById("contador").innerHTML = days + " : " + hours + " : " + minutes + " : " + seconds;
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("contador").innerHTML = "VOTACIÓN CERRADA";
            }
        }, 1000);
    </script>
</body>
</html>