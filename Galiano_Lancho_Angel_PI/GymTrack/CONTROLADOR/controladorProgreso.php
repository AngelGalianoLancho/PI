<?php
// Inicia la sesión con el nombre específico "SistemaRegistro"
session_name("SistemaRegistro");
session_start();

// Verificar si hay un usuario conectado en la sesión
// Si no hay usuario conectado, redirigir a la página de inicio
if (!isset($_SESSION["usuarioConectado"]) || empty($_SESSION["usuarioConectado"])) {
    header("Location: ../index.php");
    exit();
}

// Incluir el archivo del modelo que contiene las funciones de la lógica de negocio
require_once('../MODELO/modelo.php');

// Comprobar si la solicitud se hizo mediante el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $fecha = $_POST['fecha'] ?? null;
    $peso = $_POST['peso'] ?? null;
    $altura = $_POST['altura'] ?? null;
    $porcentaje_grasa = $_POST['porcentaje_grasa'] ?? null;

    // Validar datos: la fecha, el peso y el porcentaje de grasa son obligatorios
    if (empty($fecha) || empty($peso) || empty($porcentaje_grasa)) {
        // Configurar datos para la vista de error
        $data['title'] = "Error Establecer Progreso";
        $data['body'] = '../error.php';
        $data['message'] = "Error: Fecha, Peso y Porcentaje de Grasa son obligatorios.";
        require('../VISTA/LAYOUT/layout.php');
        exit();
    }

    // Permitir que la altura sea nula si no se proporciona
    $altura = !empty($altura) ? $altura : null;

    // Intentar establecer el progreso del usuario en la base de datos
    if (!establecerProgreso($_SESSION["usuarioConectado"], $fecha, $peso, $altura, $porcentaje_grasa)) {
        // Configurar datos para la vista de error en caso de fallo al establecer el progreso
        $data['title'] = "Error Establecer Progreso";
        $data['body'] = '../error.php';
        $data['message'] = "Error al establecer el progreso.";
        require('../VISTA/LAYOUT/layout.php');
        exit();
    }
}

// Obtener el progreso actual del usuario desde la base de datos
$progreso = obtenerProgreso($_SESSION["usuarioConectado"]);

// Configurar los datos para la vista del formulario de progreso
$data['title'] = "Establecer Progreso";
$data['body'] = '../VISTA/vistaProgreso.php';
$data['progreso'] = $progreso;

// Incluir la plantilla de layout para renderizar la vista con los datos proporcionados
require('../VISTA/LAYOUT/layout.php');
?>
