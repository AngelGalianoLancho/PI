<?php
// Inicia una sesión con el nombre "SistemaRegistro"
session_name("SistemaRegistro");
session_start();

// Verifica si la solicitud se ha realizado mediante el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica si la acción es "volver"
    if (isset($_POST['accion']) && $_POST['accion'] == 'volver') {
        // Redirige a la página de selección de opciones según el rol del usuario
        if (isset($_SESSION["rolUsuario"])) {
            $tipo = $_SESSION["rolUsuario"];
            $data = array();
            $data['title'] = "Inicio " . $_SESSION["rolUsuario"];
            $data['key'] = $_SESSION["usuarioConectado"];
            $data['body'] = $tipo == "usuario" ? '../VISTA/vistaInicioUsuario.php' : '../VISTA/vistaInicioAdministrador.php';
            require('../VISTA/LAYOUT/layout.php');
            exit();
        }
    }

    // Código para iniciar sesión
    if (isset($_POST['correo']) && isset($_POST['contraseña'])) {
        require_once('../MODELO/modelo.php');

        if (isset($_SESSION["rolUsuario"])) {
            $tipo = $_SESSION["rolUsuario"];
            $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;

            // Intenta iniciar sesión con las credenciales proporcionadas
            if (!iniciarSesion($_POST['correo'], $nombre, $_POST['contraseña'], $tipo)) {
                // Si falla la autenticación, muestra un error
                $data['title'] = "Error iniciar sesión";
                $data['body'] = '../error.php';
                require('../VISTA/LAYOUT/layout.php');
                echo '<div class="error"><p>Error al iniciar sesión del usuario</p><a href="../index.php">Volver al inicio</a></div>';
                exit();
            } elseif (!empty($_SESSION["rolUsuario"])) {
                // Si la autenticación es exitosa, guarda el correo del usuario en la sesión
                $_SESSION["usuarioConectado"] = $_POST['correo'];
                $data = array();
                $data['title'] = "Inicio " . $_SESSION["rolUsuario"];
                $data['key'] = $_SESSION["usuarioConectado"];
                $data['body'] = $_SESSION["rolUsuario"] == "usuario" ? '../VISTA/vistaInicioUsuario.php' : '../VISTA/vistaInicioAdministrador.php';
                require('../VISTA/LAYOUT/layout.php');
            }
        } else {
            // Si no hay rol de usuario en la sesión, redirige a la página principal
            header("Location: ../index.php");
            exit();
        }
    } else {
        // Si no se proporcionan el correo o la contraseña, redirige a la página principal
        header("Location: ../index.php");
        exit();
    }
} else {
    // Si la solicitud no es por método POST, redirige a la página principal
    header("Location: ../index.php");
    exit();
}
?>
