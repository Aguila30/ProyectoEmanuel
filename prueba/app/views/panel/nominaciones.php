<?php
// Importar librerías
require_once '../../helpers/menu_lateral.php';
require_once '../../helpers/funciones_globales.php';

session_start();

// Importar modelo
require_once '../../models/Tabla_nominaciones.php';

// Validación
if (!isset($_SESSION["is_logged"]) || $_SESSION["is_logged"] == false) {
    header("location: ../../../index.php?error=No has iniciado sesión&type=warning");
    exit();
}

// Modelo
$tabla_nominaciones = new Tabla_nominaciones();

// Obtener TODAS las nominaciones
$nominaciones = $tabla_nominaciones->readAllNominaciones();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nominaciones | MTV Awards</title>

    <link rel="icon" href="../../../recursos/img/system/mtv-logo.jpg">

    <!-- AdminLTE -->
    <link rel="stylesheet" href="../../../recursos/recursos_panel/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../../recursos/recursos_panel/css/adminlte.min.css">
    <link rel="stylesheet" href="../../../recursos/recursos_panel/plugins/toastr/toastr.min.css">
</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- NAVBAR -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="../dashboard.php" class="nav-link">Inicio</a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="../../backend/panel/liberate_user.php"> 
                    <i class="fas fa-power-off"></i>
                </a>
            </li>
        </ul>
    </nav>

    <!-- SIDEBAR -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="#" class="brand-link">
            <img src="../../../recursos/img/system/mtv-logo.jpg" class="brand-image elevation-3">
            <span class="brand-text font-weight-light">MTV Awards</span>
        </a>

        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="../../../recursos/img/users/<?= $_SESSION["img"] ?>" class="img-circle elevation-2">
                </div>
                <div class="info">
                    <a href="#" class="d-block"><?= $_SESSION["nickname"] ?></a>
                </div>
            </div>

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column">
                    <?= mostrar_menu_lateral("nominaciones") ?>
                </ul>
            </nav>
        </div>
    </aside>

    <!-- CONTENT -->
    <div class="content-wrapper">

        <?php
        echo mostrar_breadcrumb('Nominaciones', [
            ['tarea' => 'Listado', 'href' => './nominaciones.php']
        ]);
        ?>

        <section class="content">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Listado de Nominaciones</h3>
                    <a href="./nominacion_form.php" class="btn btn-primary float-right">
                        <i class="fas fa-plus"></i> Nueva Nominación
                    </a>
                </div>

                <div class="card-body">

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Categoría</th>
                                <th>Artista</th>
                                <th>Descripción</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php if (!empty($nominaciones)) : ?>
                            <?php foreach ($nominaciones as $n) : ?>
                                <tr>
                                    <td><?= $n->id_nominacion ?></td>
                                    <td><?= $n->categoria ?></td>
                                    <td><?= $n->artista ?></td>
                                    <td><?= $n->descripcion ?></td>

                                    <td>
                                        <a href="./nominacion_form.php?id_nominacion=<?= $n->id_nominacion ?>" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <a href="../../backend/panel/delete_nominacion.php?id=<?= $n->id_nominacion ?>" 
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('¿Eliminar nominación?');">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        <?php else : ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    No hay nominaciones registradas.
                                </td>
                            </tr>
                        <?php endif; ?>
                        </tbody>

                    </table>
                </div>

            </div>
        </section>

    </div>

    <!-- FOOTER -->
    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            MTV Awards
        </div>
        <strong>2024 © Sistema</strong>
    </footer>

</div>

<!-- Scripts -->
<script src="../../../recursos/recursos_panel/plugins/jquery/jquery.min.js"></script>
<script src="../../../recursos/recursos_panel/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../../recursos/recursos_panel/js/adminlte.min.js"></script>
<script src="../../../recursos/recursos_panel/plugins/toastr/toastr.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", () => {
<?php
if (isset($_SESSION['message'])) {
    echo mostrar_alerta_mensaje(
        $_SESSION['message']["type"],
        $_SESSION['message']["description"],
        $_SESSION['message']["title"]
    );
    unset($_SESSION['message']);
}
?>
});
</script>

</body>
</html>
