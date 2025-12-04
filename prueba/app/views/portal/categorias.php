<?php
// 1. INICIAR SESIÓN Y VALIDAR
session_start();
if (!isset($_SESSION["is_logged"]) || $_SESSION["is_logged"] == false) {
    header("location: ../../../index.php?error=Debes iniciar sesión&type=warning");
    exit();
}

// 2. IMPORTAR EL MODELO
require_once '../../models/Tabla_portal.php';
$portal = new Tabla_portal();

// 3. OBTENER DATOS
$nominaciones_raw = $portal->getNominacionesCompletas();

// 4. AGRUPAR NOMINACIONES POR CATEGORÍA (Lógica PHP)
$categorias_agrupadas = [];
foreach ($nominaciones_raw as $nom) {
    $categorias_agrupadas[$nom->nombre_categoria_nominacion][] = $nom;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MTV Awards | Categorías</title>
    
    <link rel="stylesheet" href="../../../recursos/recursos_panel/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../../recursos/recursos_panel/css/adminlte.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../../recursos/recursos_portal/css/portal.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-mtv fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="../../../recursos/img/system/mtv-logo.jpg" width="50" height="50" alt="MTV Logo" style="border-radius: 5px;">
                <span class="mtv-font ml-2" style="font-size: 1.5rem;">MTV AWARDS</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                    <li class="nav-item active"><a class="nav-link text-warning" href="#">Categorías</a></li>
                    <li class="nav-item"><a class="nav-link" href="mis_votos.php">Mis Votos</a></li>
                    
                    <li class="nav-item dropdown ml-3">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown">
                            <img src="../../../recursos/img/users/<?= $_SESSION['img'] ?>" class="rounded-circle" width="35" height="35" alt="User">
                            <span class="ml-2"><?= $_SESSION['nickname'] ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right bg-dark border-warning">
                            <a class="dropdown-item text-danger" href="../../backend/panel/liberate_user.php"><i class="fas fa-power-off mr-2"></i> Salir</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5 pt-5">
        <div class="text-center py-5">
            <h1 class="display-3 mtv-font text-warning">CATEGORÍAS NOMINADAS</h1>
            <p class="lead">Elige sabiamente. Tu voto decide la historia.</p>
        </div>
    </div>

    <div class="container pb-5">
        
        <?php if (empty($categorias_agrupadas)): ?>
            <div class="alert alert-warning text-center">
                No hay categorías activas en este momento.
            </div>
        <?php else: ?>

            <?php foreach ($categorias_agrupadas as $nombre_categoria => $nominados): ?>
                
                <div class="category-block mb-5">
                    <div class="d-flex align-items-center mb-4 border-bottom border-secondary pb-2">
                        <i class="fas fa-trophy text-warning fa-2x mr-3"></i>
                        <h2 class="mtv-font m-0"><?= $nombre_categoria ?></h2>
                    </div>

                    <div class="row">
                        <?php foreach ($nominados as $nom): ?>
                            <?php 
                                // Lógica visual: ¿Mostramos foto de artista o portada de álbum?
                                // Si la categoría dice "Artista", buscamos en la carpeta 'users'
                                // Si no, buscamos en la carpeta 'album' (singular, como tu carpeta real)

                                $es_categoria_artista = (stripos($nombre_categoria, 'Artista') !== false);

                                // CORRECCIÓN 1: Rutas exactas según tu imagen
                                if ($es_categoria_artista) {
                                    $ruta_imagen = "users/" . $nom->foto_artista; // Ej: users/badbunny.jpg
                                } else {
                                    $ruta_imagen = "album/" . $nom->imagen_album; // Ej: album/verano.jpg
                                }
                            
                                $titulo_principal = $es_categoria_artista ? $nom->pseudonimo_artista : $nom->titulo_album;
                                $subtitulo = $es_categoria_artista ? "Nominado" : $nom->pseudonimo_artista;
                            ?>

                            <div class="col-md-3 col-sm-6 mb-4">
                                <div class="card card-trend h-100 position-relative">
                                    <div style="height: 250px; overflow: hidden;">
                                        <img src="../../../recursos/img/<?= $ruta_imagen ?>" class="w-100 h-100" style="object-fit: cover;" alt="Nominado">
                                    </div>

                                    <div class="card-body text-center">
                                        <h5 class="mtv-font text-warning mb-1"><?= $titulo_principal ?></h5>
                                        <p class="text-muted small mb-3"><?= $subtitulo ?></p>

                                        <form action="../../backend/portal/registrar_voto.php" method="POST">
                                            <input type="hidden" name="id_nominacion" value="<?= $nom->id_nominacion ?>">
                                            <button type="submit" class="btn btn-outline-light btn-block btn-sm font-weight-bold">
                                                <i class="fas fa-vote-yea text-warning"></i> VOTAR
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            <?php endforeach; ?>

        <?php endif; ?>

    </div>

    <footer class="bg-black py-4 text-center border-top border-secondary">
        <p class="text-muted m-0">MTV Awards System © 2025.</p>
    </footer>

    <script src="../../../recursos/recursos_panel/plugins/jquery/jquery.min.js"></script>
    <script src="../../../recursos/recursos_panel/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
<?php
    if (isset($_GET['status']) && $_GET['status'] == 'duplicado') {
        echo '
            <div class="alert alert-danger alert-dismissible fade show fixed-top m-3" role="alert" style="z-index: 9999;">
                <strong><i class="fas fa-exclamation-triangle"></i> ¡Error!</strong> 
                Ya has registrado un voto para esta nominación anteriormente.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        ';
    }
?>
</html>