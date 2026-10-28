<?php
session_name("SistemaRegistro");
session_start();

require_once('../MODELO/modelo.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["accion"])) {
    $accion = $_POST["accion"];
    $correo_usuario = $_POST["correo_usuario"] ?? null;

    if ($accion === "eliminar" && $correo_usuario) {
        $resultado = eliminarUsuario($correo_usuario);
        if ($resultado) {
            echo "Usuario eliminado correctamente.";
        } else {
            echo "Error al eliminar el usuario.";
        }
    } elseif ($accion === "actualizar" && $correo_usuario) {
        $nombre_usuario = $_POST["nombre_usuario"] ?? null;
        $contrasena_usuario = $_POST["contrasena_usuario"] ?? null;
        $peso = $_POST["peso"] ?? null;
        $altura = $_POST["altura"] ?? null;
        $porcentaje_grasa = $_POST["porcentaje_grasa"] ?? null;

        actualizarUsuario($correo_usuario, $nombre_usuario, $contrasena_usuario, $peso, $altura, $porcentaje_grasa);
    }
}

$usuarios = obtenerUsuarios();

$data['title'] = "Gestión de Usuarios";
$data['body'] = '../VISTA/vistaGestionUsuario.php';
$data['usuarios'] = $usuarios;

require('../VISTA/LAYOUT/layout.php');
?>
