<?php
// Inicia una sesión con el nombre "SistemaRegistro"
session_name("SistemaRegistro");
session_start();

// Verifica si el usuario no está conectado
if (!isset($_SESSION["usuarioConectado"]) || empty($_SESSION["usuarioConectado"])) {
    // Si no está conectado, redirige al usuario a la página de inicio de sesión y termina la ejecución del script
    header("Location: ../index.php");
    exit();
}

// Incluye el archivo modelo.php que contiene funciones necesarias
require_once('../MODELO/modelo.php');

// Obtiene el correo del usuario conectado desde la sesión
$usuario_correo = $_SESSION["usuarioConectado"];

// Verifica si el formulario ha sido enviado mediante el método POST y si los campos necesarios están presentes
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nombre_rutina"]) && isset($_POST["descripcion"]) && isset($_POST["ejercicios"])) {
    // Asigna los valores del formulario a variables
    $nombre_rutina = $_POST['nombre_rutina'];
    $descripcion = $_POST['descripcion'];
    $ejercicios = json_decode($_POST['ejercicios'], true); // Decodifica el JSON de ejercicios a un array


    // Intenta establecer la rutina de entrenamiento con los datos proporcionados
    if (!establecerRutinaEntrenamiento($usuario_correo, $nombre_rutina, $descripcion, $ejercicios)) {
        // Si hay un error al establecer la rutina, prepara datos para mostrar un mensaje de error
        $data['title'] = "Error al establecer rutina";
        $data['body'] = '../error.php';
        require('../VISTA/LAYOUT/layout.php');
        echo '<div class="error">
            <p>Error al establecer la rutina</p>
            <a href="controladorRutina.php">Volver al formulario</a>
            </div>';
        exit();
    }

    // Después de establecer la rutina, obtiene el historial de rutinas actualizado
    $rutinas = obtenerHistorialRutinas($usuario_correo);
}

// Si el formulario no ha sido enviado, o después de haberlo procesado correctamente, obtiene el historial de rutinas del usuario
$rutinas = obtenerHistorialRutinas($usuario_correo);

// Prepara los datos para la vista
$data['title'] = "Rutinas de Entrenamiento";
$data['body'] = '../VISTA/vistaRutinaEntrenamiento.php';
$data['rutinas'] = $rutinas;

// Incluye la plantilla de layout para mostrar la vista con los datos preparados
require('../VISTA/LAYOUT/layout.php');
?>
