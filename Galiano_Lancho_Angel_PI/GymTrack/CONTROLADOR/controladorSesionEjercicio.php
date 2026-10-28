<?php
// Establecer el nombre de la sesión
session_name("SistemaRegistro");

// Iniciar la sesión
session_start();

// Verificar si el usuario está conectado, si no, redirigir al usuario a la página de inicio de sesión
if (!isset($_SESSION["usuarioConectado"]) || empty($_SESSION["usuarioConectado"])) {
    header("Location: ../index.php");
    exit();
}

// Incluir el archivo que contiene las funciones del modelo
require_once('../MODELO/modelo.php');

// Verificar si el formulario ha sido enviado por el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["rutina_id"]) && isset($_POST["duracion"]) && isset($_POST["detalle"])) {
    // Recoger los datos enviados por el formulario
    $rutina_id = $_POST['rutina_id'];
    $duracion = $_POST['duracion'];
    $detalle = $_POST['detalle'];
    // Obtener la fecha actual
    $fecha = date('Y-m-d');

    // Registrar la sesión de ejercicio en la base de datos
    if (!registrarSesionEjercicio($_SESSION["usuarioConectado"], $fecha, $rutina_id, $duracion, $detalle)) {
        // Si la función registrarSesionEjercicio devuelve false, mostrar un mensaje de error
        $data['title'] = "Error al registrar sesión de ejercicio";
        $data['body'] = '../error.php';
        require('../VISTA/LAYOUT/layout.php');
        echo '<div class="error">
            <p>Error al registrar la sesión de ejercicio</p>
            <a href="controladorSesionEjercicio.php">Volver al formulario</a>
            </div>';
        exit();
    }
}

// Obtener el historial de sesiones del usuario conectado
$sesiones = obtenerHistorialSesiones($_SESSION["usuarioConectado"]);

// Obtener las rutinas disponibles para el usuario conectado
$rutinas = obtenerRutinas($_SESSION["usuarioConectado"]);

// Preparar los datos para ser mostrados en la vista
$data['title'] = "Sesiones de Ejercicio";
$data['body'] = '../VISTA/vistaSesionEjercicio.php';
$data['sesiones'] = $sesiones;
$data['rutinas'] = $rutinas;

// Incluir la vista dentro del layout principal
require('../VISTA/LAYOUT/layout.php');
?>
