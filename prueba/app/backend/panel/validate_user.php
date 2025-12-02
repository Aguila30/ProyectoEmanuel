<?php
    require_once '../../models/Tabla_usuarios.php';

    //Inciar la sesion
    session_start();

    // echo 'Validando información...<br>';
    $message = '';
    $type = '';

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        echo 'Analizando Datos...';
        //Instancia del modelo Tabla_usuarios
        $tabla_usuario = new Tabla_usuarios();

        // $_POST['variableinterfaz'] | $_GET["variableinterfaz"]
        if(isset($_POST["email"]) && isset($_POST["password"])){
            $email = $_POST["email"];
            $pass = $_POST["password"];

            //Executo la petición
            $data = $tabla_usuario->validateUser($email, $pass);
            
            // print_r($data);
            if (!empty($data)) {
                $_SESSION["is_logged"] = true;
                $_SESSION["id_usuario"] = true;
                $_SESSION["name"] = $data->id_usuario;
                $_SESSION["email"] = $data->email_usuario;
                $_SESSION["nickname"] = $data->nombre_usuario;
                $_SESSION["img"] = (is_null($data->imagen_usuario)) ? (($data->sexo_usuario == 0) ? 'woman.png' : 'man.png' ) : $data->imagen_usuario;

                $_SESSION['message'] = array("type" => "info", "description" => "Bienvenido al sistema", "title" => "Inicio de sesión éxitoso");

                header('Location: ../../views/panel/dashboard.php');
                exit();

            }//end if
            else{
                //Unset all session variables
                session_unset();

                //Destroy session
                session_destroy();

                $type = 'danger';
                $message = 'Correo electrónico o contraseña son incorrectas.';
                header('Location: ../../../index.php?error='.$message.'&type='.$type);
                exit();

            }//end else
        }//end if 
        else{
            $type = 'warning';
            $message = 'Las credenciales de acceso son requeridas.';
            header('Location: ../../../index.php?error='.$message.'&type='.$type);
            exit();
        }//end else
    }//end REQUEST_METHOD
    else{
        $type = 'warning';
        $message = 'Error al procesar los datos...';
        header('Location: ../../../index.php?error='.$message.'&type='.$type);
        exit();
    }//end else REQUEST_METHOD