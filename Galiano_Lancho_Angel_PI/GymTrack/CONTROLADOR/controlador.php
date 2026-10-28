<?php
    // Incluir la lógica del modelo
    require_once('./MODELO/modelo.php');

    // Iniciamos una sesión con un nombre específico para mantener al usuario conectado y almacenar su rol
    session_name("SistemaRegistro");
    session_start();

    // Inicializamos las variables de sesión para el usuario conectado y su rol
    $_SESSION["usuarioConectado"] = "";
    $_SESSION["rolUsuario"] = "";

    // Preparar datos para la vista
    $data = array();
    $data['title'] = "GymTrack"; // Título de la página
    $data['body'] = 'VISTA/vista.php'; // Ruta del archivo de la vista principal

    // Incluir el layout de la vista que utiliza los datos preparados
    require('./VISTA/LAYOUT/layout.php');
?>
