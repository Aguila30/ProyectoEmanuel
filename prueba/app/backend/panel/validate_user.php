<?php
// backend/panel/validate_user.php

// 1. Importar el modelo
require_once '../../models/Tabla_usuarios.php';

// 2. Iniciar sesión SIEMPRE al principio
session_start();

// Variables de control
$message = '';
$type = '';

// 3. Verificar que sea una petición POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $tabla_usuario = new Tabla_usuarios();

    if (isset($_POST["email"]) && isset($_POST["password"])) {
        
        // Sanitización básica
        $email = trim($_POST["email"]);
        $pass = trim($_POST["password"]);

        // Ejecutar validación en el modelo
        $data = $tabla_usuario->validateUser($email, $pass);

        // Si $data no está vacío, el usuario existe
        if (!empty($data)) {
            
            // --- GUARDAR DATOS EN SESIÓN ---
            $_SESSION["is_logged"] = true;
            $_SESSION["id_usuario"] = $data->id_usuario;
            $_SESSION["id_rol"] = $data->id_rol; // 749 (Admin), 599 (Fan), 379 (Artista)
            
            // Concatenar nombre completo si lo necesitas, o usar nickname
            $_SESSION["name"] = $data->nombre_usuario . ' ' . $data->ap_usuario;
            $_SESSION["nickname"] = $data->nombre_usuario;
            $_SESSION["email"] = $data->email_usuario;

            // Lógica de Imagen: Si es NULL, asignar avatar por defecto según sexo
            if (empty($data->imagen_usuario)) {
                // 0 = Mujer, Otro = Hombre (según tu lógica)
                $_SESSION["img"] = ($data->sexo_usuario == 0) ? 'woman.png' : 'man.png';
            } else {
                $_SESSION["img"] = $data->imagen_usuario;
            }

            // --- REDIRECCIONAMIENTO POR ROL ---
            switch ($data->id_rol) {
                case 749: // ADMINISTRADOR
                    $_SESSION['message'] = array(
                        "type" => "success", 
                        "title" => "Bienvenido Admin", 
                        "description" => "Has ingresado al panel de control."
                    );
                    header('Location: ../../views/panel/dashboard.php');
                    break;

                case 599: // USUARIO COMÚN (Fan/Votante)
                    // Redirige a la carpeta "portal" que ya tienes
                    header('Location: ../../views/portal/index.php');
                    break;

                case 379: // ARTISTA
                    // Los artistas también van al portal por ahora
                    header('Location: ../../views/portal/index.php');
                    break;
                case 249: // MANAGER
                    // Los artistas también van al portal por ahora
                    header('Location: ../../views/panel/PanelManager.php');
                    break;

                default:
                    // Rol desconocido: Seguridad
                    session_unset();
                    session_destroy();
                    $message = 'Error: Tu usuario no tiene permisos válidos.';
                    header('Location: ../../../index.php?error=' . urlencode($message) . '&type=danger');
                    break;
            }
            
            exit(); // Detiene el script aquí.

        } else {
            // --- DATOS INCORRECTOS ---
            session_unset();
            session_destroy();
            $message = 'El correo o la contraseña son incorrectos.';
            header('Location: ../../../index.php?error=' . urlencode($message) . '&type=danger');
            exit();
        }
    } else {
        // --- FALTAN CAMPOS ---
        $message = 'Ingresa tu correo y contraseña.';
        header('Location: ../../../index.php?error=' . urlencode($message) . '&type=warning');
        exit();
    }
} else {
    // --- ACCESO DENEGADO (NO ES POST) ---
    header('Location: ../../../index.php');
    exit();
}
?>