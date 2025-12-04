<?php
    // Importar librerias
    require_once '../../helpers/menu_lateral.php';
    require_once '../../helpers/funciones_globales.php';

    // Importar Modelo de Artistas
    require_once '../../models/Tabla_artistas.php';

    // Reinstanciar la variable de sesión
    session_start();

    // Validación de seguridad
    if(!isset($_SESSION["is_logged"]) || ($_SESSION["is_logged"] == false)){
        header("location: ../../../index.php?error=No has iniciado sesión&type=warning");
        exit();
    }

    // Instancia del Objeto Artistas
    $Tabla_artistas = new Tabla_artistas();
    
    // Obtener todos los artistas
    $artistas = $Tabla_artistas->readAllArtistas();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Artistas | MTV Awards</title>
    <link rel="icon" href="../../../recursos/img/system/mtv-logo.jpg" type="image/x-icon">
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="../../../recursos/recursos_panel/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../../recursos/recursos_panel/css/adminlte.min.css">

    <link rel="stylesheet" href="../../../recursos/recursos_panel/plugins/toastr/toastr.min.css">
    
    <link rel="stylesheet" href="../../../recursos/recursos_panel/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../../recursos/recursos_panel/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../../../recursos/recursos_panel/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="./dashboard.php" class="nav-link">Inicio</a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../../backend/panel/liberate_user.php" role="button" 
                        data-toggle="tooltip" data-placement="top" title="Cerrar Sesión" >
                        <i class="fa fa-window-close"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="./dashboard.php" class="brand-link">
                <img src="../../../recursos/img/system/mtv-logo.jpg" alt="MTV Logo"
                    class="brand-image elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">MTV Awards</span>
            </a>

            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="../../../recursos/img/users/<?= $_SESSION["img"] ?>" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"><?= $_SESSION["nickname"] ?></a>
                    </div>
                </div>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <?= mostrar_menu_lateral("ARTISTAS") ?>
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper">
            <?php
                    $breadcrumb = array(
                        array(
                            'tarea' => 'Artistas',   
                            'href' => '#'   
                        )
                    );    
                    echo mostrar_breadcrumb('Gestión de Artistas', $breadcrumb); 
                ?>
            
            <section class="content">

                <div class="card">
                    <div class="card-header">
                        <a href="./artista_nuevo.php" class="btn btn-block btn-dark">
                            <i class="fa fa-plus-circle"></i> Agregar Artista
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="card">
                            <div class="card-header text-center">
                                <h3 class="card-title">Catálogo de Artistas</h3>
                            </div>
                            
                            <div class="card-body">
                                <table id="table-artistas" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Artista (Pseudónimo)</th>
                                            <th>Nacionalidad</th>
                                            <th>Estatus</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $html = '';
                                            if(!empty($artistas)){
                                                $count = 0;
                                                foreach ($artistas as $artista) {
                                                    
                                                    // --- INICIO CORRECCIÓN DE IMAGEN ---
                                                    $nombre_imagen = $artista->imagen_usuario;
                                                    
                                                    // Rutas posibles
                                                    $ruta_users = '../../../recursos/img/users/' . $nombre_imagen;
                                                    $ruta_artistas = '../../../recursos/img/artistas/' . $nombre_imagen;
                                                    
                                                    // Imagen por defecto inicial
                                                    $img = '../../../recursos/img/users/user.png'; 

                                                    // Lógica de búsqueda
                                                    if (!empty($nombre_imagen)) {
                                                        if (file_exists($ruta_users)) {
                                                            // Prioridad 1: Carpeta Users
                                                            $img = $ruta_users;
                                                        } elseif (file_exists($ruta_artistas)) {
                                                            // Prioridad 2: Carpeta Artistas
                                                            $img = $ruta_artistas;
                                                        }
                                                    }
                                                    // --- FIN CORRECCIÓN DE IMAGEN ---

                                                    $html.= '
                                                        <tr>
                                                            <td>'.++$count.'</td>
                                                            <td>
                                                                <img src="'.$img.'" class="img-rounded mr-2" alt="img-artista" width="40px" style="object-fit:cover; height:40px;">
                                                                <strong>'.$artista->pseudonimo_artista.'</strong>
                                                            </td>
                                                            <td>'.$artista->nacionalidad_artista.'</td>';
                                                            
                                                            // Estatus
                                                            if($artista->estatus_artista == 2){ 
                                                                $html.= '<td>
                                                                                <span class="badge badge-success">Activo</span>
                                                                                <br>
                                                                                <a href="../../backend/panel/estatus_artista.php?id='.$artista->id_artista.'&estatus=-1" class="btn btn-xs btn-outline-danger mt-1">Deshabilitar</a>
                                                                         </td>';
                                                            }
                                                            else{
                                                                $html.= '<td>
                                                                                <span class="badge badge-danger">Inactivo</span>
                                                                                <br>
                                                                                <a href="../../backend/panel/estatus_artista.php?id='.$artista->id_artista.'&estatus=2" class="btn btn-xs btn-outline-success mt-1">Habilitar</a>
                                                                         </td>';
                                                            }

                                                    $html.='<td>
                                                                <div class="btn-group">
                                                                    <a href="./artista_detalles.php?id='.$artista->id_artista.'" class="btn btn-warning btn-sm" title="Editar">
                                                                        <i class="fa fa-edit text-white"></i>
                                                                    </a>
                                                                    <a href="../../backend/panel/delete_artista.php?id='.$artista->id_artista.'" class="btn btn-danger btn-sm" onclick="return confirm(\'¿Estás seguro de eliminar este artista?\')" title="Eliminar">
                                                                        <i class="fa fa-trash"></i>
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>';
                                                }
                                            }
                                            echo $html;
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Artista</th>
                                            <th>Nacionalidad</th>
                                            <th>Estatus</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        MTV Awards System
                    </div>
                </div>

            </section>
        </div>

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 1.0.0
            </div>
            <strong>Copyright &copy; 2025 MTV Awards.</strong> Todos los derechos reservados.
        </footer>

    </div>

    <script src="../../../recursos/recursos_panel/plugins/jquery/jquery.min.js"></script>
    <script src="../../../recursos/recursos_panel/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../../recursos/recursos_panel/js/adminlte.min.js"></script>
    
    <script src="../../../recursos/recursos_panel/plugins/toastr/toastr.min.js"></script>

    <script src="../../../recursos/recursos_panel/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../../recursos/recursos_panel/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../../recursos/recursos_panel/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../../recursos/recursos_panel/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../../../recursos/recursos_panel/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../../../recursos/recursos_panel/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    
    <script>
        $(function () {
            $("#table-artistas").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
            }
            }).buttons().container().appendTo('#table-artistas_wrapper .col-md-6:eq(0)');
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            <?php 
                if(isset($_SESSION['message'])){
                    echo mostrar_alerta_mensaje($_SESSION['message']["type"], $_SESSION['message']["description"],$_SESSION['message']["title"]);
                    unset($_SESSION['message']);         
                }
            ?>
        });
    </script>
</body>
</html>