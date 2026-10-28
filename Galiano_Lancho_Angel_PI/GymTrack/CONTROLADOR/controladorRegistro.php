<?php
// Iniciamos la sesión y le asignamos un nombre específico "SistemaRegistro"
session_name("SistemaRegistro");
session_start();

// Verificamos si se ha enviado una solicitud POST y si se ha establecido el tipo de usuario
// o si ya hay un rol de usuario almacenado en la sesión
if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['tipo']) || $_SESSION["rolUsuario"] != "")) {
    // Si se ha establecido el tipo de usuario en el formulario, actualizamos el rol de usuario en la sesión
    if (isset($_POST['tipo'])) {
        $_SESSION["rolUsuario"] = $_POST['tipo'];
    }
    // Incluimos el archivo del modelo para interactuar con la capa de datos
    require_once('../MODELO/modelo.php');

    // Preparamos los datos que se pasarán a la vista
    $data = array();
    $data['title'] = "Registro " . $_SESSION["rolUsuario"]; // Título de la página basado en el rol de usuario
    $data['body'] = '../VISTA/vistaRegistroUsuario.php'; // Vista específica para registro de usuarios

    // Incluimos el layout que renderiza la página completa
    require('../VISTA/LAYOUT/layout.php');
} elseif ($_SERVER["REQUEST_METHOD"] == "GET" && $_SESSION["rolUsuario"] != "") {
    // Si se ha realizado una solicitud GET y ya hay un rol de usuario en la sesión
    // Incluimos el archivo del modelo para interactuar con la capa de datos
    require_once('../MODELO/modelo.php');

    // Preparamos los datos que se pasarán a la vista
    $data = array();
    $data['title'] = "Login " . $_SESSION["rolUsuario"]; // Título de la página basado en el rol de usuario

    // Determinamos la vista que se mostrará de acuerdo al rol de usuario
    if ($_SESSION["rolUsuario"] == "usuario") {
        $data['body'] = '../VISTA/vistaRegistroUsuario.php'; // Vista para usuarios normales
    } else {
        $data['body'] = '../VISTA/vistaRegistroAdministrador.php'; // Vista para administradores
    }

    // Incluimos el layout que renderiza la página completa
    require('../VISTA/LAYOUT/layout.php');
} else {
    // Si no se ha enviado correctamente el formulario o no hay un rol de usuario en la sesión
    // Redirigimos al índice principal del sitio
    header("Location: ../index.php");
    exit();
}
?>
