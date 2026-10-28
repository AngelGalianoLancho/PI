<?php
// Función para crear una conexión utilizando la extensión mysqli
function crear_conexion($servidor, $usuario, $contrasena, $base_datos)
{
    return new mysqli($servidor, $usuario, $contrasena, $base_datos);
}

// Función para crear una conexión utilizando PDO
function crear_conexionPDO($servidor, $usuario, $contrasena, $base_datos)
{
    return new PDO("mysql:host=$servidor;dbname=$base_datos", $usuario, $contrasena);
}

// Función para cerrar una conexión mysqli
function cerrar_conexion($conexion)
{
    $conexion->close();
}

// Función para ejecutar una consulta SQL en la base de datos
function consulta_base_de_datos($consulta, $conexion)
{
    return $conexion->query($consulta);
}

// Función para obtener una fila de resultados como un array asociativo
function obtener_resultados($resultado)
{
    return $resultado->fetch_assoc();
}
?>
