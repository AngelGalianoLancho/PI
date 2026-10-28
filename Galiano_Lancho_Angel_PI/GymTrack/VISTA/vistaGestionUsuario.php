<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
</head>
<body>
    <h1>Gestión de Usuarios</h1>
    <?php if (!empty($data['usuarios'])): ?>
        <table border="1">
            <tr>
                <th>Correo</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
            <?php foreach ($data['usuarios'] as $usuario): ?>
                <tr>
                    <td><?php echo htmlspecialchars($usuario['correo']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                    <td>
                        <form action="../CONTROLADOR/controladorGestionUsuarios.php" method="post" style="display:inline;">
                            <input type="hidden" name="correo_usuario" value="<?php echo htmlspecialchars($usuario['correo']); ?>">
                            <input type="hidden" name="accion" value="eliminar">
                            <input type="submit" value="Eliminar">
                        </form>
                        <form action="../CONTROLADOR/controladorGestionUsuarios.php" method="post" style="display:inline;">
                            <input type="hidden" name="correo_usuario" value="<?php echo htmlspecialchars($usuario['correo']); ?>">
                            <input type="hidden" name="accion" value="actualizar">
                            Nombre: <input type="text" name="nombre_usuario" value="<?php echo htmlspecialchars($usuario['nombre']); ?>"><br>
                            Contraseña: <input type="password" name="contrasena_usuario"><br>
                            Peso: <input type="number" step="0.01" name="peso" value="<?php echo htmlspecialchars($usuario['peso'] ?? ''); ?>"><br>
                            Altura: <input type="number" step="0.01" name="altura" value="<?php echo htmlspecialchars($usuario['altura'] ?? ''); ?>"><br>
                            % Grasa: <input type="number" step="0.01" name="porcentaje_grasa" value="<?php echo htmlspecialchars($usuario['porcentaje_grasa'] ?? ''); ?>"><br>
                            <input type="submit" value="Actualizar">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No hay usuarios registrados.</p>
    <?php endif; ?>
    <form method="POST" action="controladorInicio.php">
        <button type="submit" name="accion" value="volver" class="centered-button">Volver a selección de opciones</button>
    </form>
</body>
</html>
