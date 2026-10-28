<?php
// Se define un nombre de sesión específico para el sistema de registro
session_name("SistemaRegistro");
// Se inicia la sesión con el nombre especificado
session_start();

// Verifica si no hay un usuario conectado (es decir, si no hay un valor en la sesión para "usuarioConectado")
if (!isset($_SESSION["usuarioConectado"]) || empty($_SESSION["usuarioConectado"])) {
    // Si no hay un usuario conectado, redirige al usuario a la página de inicio de sesión
    header("Location: ../index.php");
    exit();
}

// Incluye el archivo del modelo que contiene funciones relacionadas con la base de datos
require_once('../MODELO/modelo.php');

// Obtiene el correo electrónico del usuario conectado desde la sesión
$usuario_correo = $_SESSION["usuarioConectado"];

// Verifica si se ha enviado el formulario mediante el método POST y si las variables necesarias están presentes
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["tipo_objetivo"]) && isset($_POST["peso_objetivo"]) && isset($_POST["fecha_limite"])) {
    // Obtiene los valores del formulario
    $tipo_objetivo = $_POST['tipo_objetivo'];
    $peso_objetivo = $_POST['peso_objetivo'];
    $fecha_limite = $_POST['fecha_limite'];

    // Intenta establecer un nuevo objetivo para el usuario
    if (!establecerObjetivo($usuario_correo, $tipo_objetivo, $peso_objetivo, $fecha_limite)) {
        // Si ocurre un error al establecer el objetivo, prepara los datos para la vista de error
        $data['title'] = "Error al establecer objetivo";
        $data['body'] = '../error.php';
        require('../VISTA/LAYOUT/layout.php');
        // Muestra un mensaje de error y un enlace para volver al formulario
        echo '<div class="error">
            <p>Error al establecer el objetivo</p>
            <a href="controladorObjetivos.php">Volver al formulario</a>
            </div>';
        exit();
    }
}

// Obtiene el historial de objetivos del usuario
$objetivos = obtenerHistorialObjetivos($usuario_correo);

// Prepara los datos para la vista de objetivos
$data['title'] = "Objetivos";
$data['body'] = '../VISTA/vistaObjetivos.php';
$data['objetivos'] = $objetivos;

// Incluye la plantilla de diseño con los datos preparados
require('../VISTA/LAYOUT/layout.php');
?>
