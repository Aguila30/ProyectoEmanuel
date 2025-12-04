<?php
// app/backend/portal/registrar_voto.php

session_start();

// 1. Validar seguridad: ¿Está logueado?
if (!isset($_SESSION["is_logged"]) || $_SESSION["is_logged"] == false) {
    header("location: ../../../index.php");
    exit();
}

// 2. Importar el modelo
require_once '../../models/Tabla_portal.php';

// 3. Verificar que recibimos datos por POST
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_nominacion'])) {
    
    $id_nominacion = $_POST['id_nominacion'];
    $id_usuario = $_SESSION['id_usuario']; // Sacamos el ID de la sesión

    // 4. Instanciar y guardar
    $portal = new Tabla_portal();
    $resultado = $portal->registrarVoto($id_usuario, $id_nominacion);

    // 5. Redirigir con mensaje según el resultado
    if ($resultado == "exito") {
        header("Location: ../../views/portal/categorias.php?status=ok");
    } elseif ($resultado == "duplicado") {
        header("Location: ../../views/portal/categorias.php?status=duplicado");
    } else {
        header("Location: ../../views/portal/categorias.php?status=error");
    }

} else {
    // Si intentan entrar directo sin dar clic al botón
    header("Location: ../../views/portal/categorias.php");
}
?>