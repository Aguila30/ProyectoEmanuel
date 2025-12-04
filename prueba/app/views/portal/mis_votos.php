<?php
// 1. Validar sesión
session_start();
if (!isset($_SESSION["is_logged"]) || $_SESSION["is_logged"] == false) {
    header("location: ../../../index.php?error=Debes iniciar sesión&type=warning");
    exit();
}

// 2. Importar Modelo
require_once '../../models/Tabla_portal.php';
$portal = new Tabla_portal();

// 3. Obtener los votos DEL USUARIO LOGUEADO
$mis_votos = $portal->getMisVotos($_SESSION['id_usuario']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MTV Awards | Mis Votos</title>
    
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
                    <li class="nav-item"><a class="nav-link" href="categorias.php">Categorías</a></li>
                    <li class="nav-item active"><a class="nav-link text-warning" href="#">Mis Votos</a></li>
                    
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
            <h1 class="display-3 mtv-font text-white">HISTORIAL DE VOTOS</h1>
            <p class="lead text-muted">Aquí están tus elecciones. ¡Gracias por hacer historia!</p>
        </div>
    </div>

    <div class="container pb-5">
        
        <?php if (empty($mis_votos)): ?>
            <div class="text-center py-5">
                <i class="fas fa-vote-yea fa-4x text-secondary mb-3"></i>
                <h3 class="mtv-font text-muted">Aún no has votado</h3>
                <p>¿Qué esperas? Tus artistas favoritos te necesitan.</p>
                <a href="categorias.php" class="btn btn-mtv mt-3">IR A VOTAR</a>
            </div>
        <?php else: ?>

            <div class="card bg-dark border-secondary">
                <div class="card-body p-0">
                    <table class="table table-hover table-dark m-0">
                        <thead>
                            <tr class="text-warning text-uppercase">
                                <th class="pl-4">Fecha</th>
                                <th>Categoría</th>
                                <th>Tu Elección</th>
                                <th class="text-center">Detalle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($mis_votos as $voto): ?>
                                <?php 
                                    // Lógica visual: ¿Votó por artista o álbum?
                                    $es_artista = (stripos($voto->nombre_categoria_nominacion, 'Artista') !== false);
                                    
                                    // Definir imagen y nombre a mostrar
                                    $nombre_mostrar = $es_artista ? $voto->pseudonimo_artista : $voto->titulo_album;
                                    
                                    // Imagen (con la lógica de rutas que ya aprendimos)
                                    $foto_base = $es_artista ? $voto->foto_artista : $voto->imagen_album;
                                    $carpeta = $es_artista ? 'users' : 'albums'; 
                                    
                                    // Corrección rápida para ruta de imagen
                                    $ruta_img = "../../../recursos/img/$carpeta/$foto_base";
                                    // Si es artista, aplicamos tu lógica de doble carpeta por seguridad
                                    if ($es_artista) {
                                        if (!file_exists($ruta_img)) {
                                            $ruta_img = "../../../recursos/img/artistas/$foto_base";
                                        }
                                    }
                                ?>
                                <tr>
                                    <td class="pl-4 align-middle text-muted">
                                        <?= date("d/M/Y", strtotime($voto->fecha_votacion)) ?>
                                    </td>
                                    <td class="align-middle">
                                        <span class="badge badge-warning text-dark"><?= $voto->nombre_categoria_nominacion ?></span>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center">
                                            <img src="<?= $ruta_img ?>" class="rounded-circle mr-3 border border-secondary" width="50" height="50" style="object-fit: cover;">
                                            <div>
                                                <h5 class="m-0 mtv-font"><?= $nombre_mostrar ?></h5>
                                                <?php if (!$es_artista): ?>
                                                    <small class="text-muted">De: <?= $voto->pseudonimo_artista ?></small>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center">
                                        <i class="fas fa-check-circle text-success fa-lg" title="Voto Registrado"></i>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="categorias.php" class="btn btn-outline-light">
                    <i class="fas fa-plus"></i> SEGUIR VOTANDO
                </a>
            </div>

        <?php endif; ?>

    </div>

    <footer class="bg-black py-4 text-center border-top border-secondary mt-5">
        <p class="text-muted m-0">MTV Awards System © 2025.</p>
    </footer>

    <script src="../../../recursos/recursos_panel/plugins/jquery/jquery.min.js"></script>
    <script src="../../../recursos/recursos_panel/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>