<?php
// Establece el nombre de la sesión y la inicia
session_name("SistemaRegistro");
session_start();

// Configura la visualización de errores para el desarrollo
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// // Muestra el contenido del array $_POST para fines de depuración
// print_r($_POST);

// Si no hay un rol de usuario en la sesión y se envió un tipo de usuario en POST, lo guarda en la sesión
if (!$_SESSION['rolUsuario'] && $_POST['tipo']):
    $_SESSION['rolUsuario']=$_POST['tipo'];
endif;

// Si la solicitud es POST y se envían los campos 'correo', 'contraseña' y 'rolUsuario' en la sesión
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['correo'], $_POST['contraseña'], $_SESSION["rolUsuario"])) {
    require_once('../MODELO/modelo.php');  // Incluye el archivo de modelo
    
    // Obtiene el nombre si está presente en la solicitud POST, de lo contrario, es null
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;

    // Intenta registrar al usuario con los datos proporcionados
    if (!registrar($_POST['correo'], $nombre, $_POST['contraseña'], $_SESSION["rolUsuario"])) {
        // Si el registro falla, configura los datos para la página de error y la muestra
        $data['title'] = "Error registro";
        $data['body'] = '../error.php';
        require('../VISTA/LAYOUT/layout.php');
        echo '<div class="error"><p>Error al registrar el usuario</p><a href="../index.php">Volver al inicio</a></div>';
        exit();
    } elseif ($_SESSION["rolUsuario"] == "administrador") {
        // Si el usuario es administrador, redirige al controlador de inicio
        header("Location: controladorInicio.php");
        exit();
    }
}

// Si la solicitud es POST y se envía el 'tipo' o ya hay un 'rolUsuario' en la sesión
if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['tipo']) || $_SESSION["rolUsuario"] != "")) {
    // Si se envía el tipo de usuario en POST, actualiza el rol en la sesión
    if (isset($_POST['tipo'])) {
        $_SESSION["rolUsuario"] = $_POST['tipo'];
    }
    $data = array();
    $data['title'] = "Login " . $_SESSION["rolUsuario"];
    
    // Configura la vista según el rol del usuario
    if ($_SESSION["rolUsuario"] == "usuario") {
        $data['body'] = '../VISTA/vistaLoginUsuario.php';
    } else {
        $data['body'] = '../VISTA/vistaLoginAdministrador.php';
    }
    // Muestra la vista configurada
    require('../VISTA/LAYOUT/layout.php');

// Si la solicitud es GET y hay un rol de usuario en la sesión
} elseif ($_SERVER["REQUEST_METHOD"] == "GET" && $_SESSION["rolUsuario"] != "") {
    $data = array();
    $data['title'] = "Login " . $_SESSION["rolUsuario"];
    $data['body'] = '../VISTA/vistaLoginUsuario.php';
    require('../VISTA/LAYOUT/layout.php');

// Si no se cumplen ninguna de las condiciones anteriores, redirige a la página principal
} else {
    header("Location: ../index.php");
    exit();
}
?>
