<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sesiones de Ejercicio</title>
    <link rel="stylesheet" href="layout.css"> <!-- Agrega la hoja de estilos -->
</head>
<body>
    <!-- Encabezado para la sección de registro de sesiones -->
    <h1>Registra Sesiones</h1>
    <!-- Formulario para registrar una nueva sesión de ejercicio -->
    <form action="controladorSesionEjercicio.php" method="post">
        <!-- Campo para seleccionar la rutina -->
        <label for="rutina_id">Rutina:</label>
        <select name="rutina_id" id="rutina_id" class="select-box" required>
            <option value="">Seleccione una rutina</option>
            <!-- Iterar sobre las rutinas disponibles y mostrarlas en el select -->
            <?php foreach ($data['rutinas'] as $rutina): ?>
                <option value="<?= htmlspecialchars($rutina['id']) ?>"><?= htmlspecialchars($rutina['nombre']) ?></option>
            <?php endforeach; ?>
        </select><br><br>
        <!-- Campo para la duración de la sesión -->
        <label for="duracion">Duración:</label>
        <input type="time" name="duracion" id="duracion" class="time-input" required><br><br>
        <!-- Campo para los detalles de la sesión -->
        <label for="detalle">Detalle:</label>
        <input type="text" name="detalle" id="detalle" class="text-input"><br><br>
        <!-- Botón para enviar el formulario y registrar la sesión -->
        <input type="submit" value="Registrar Sesión">
    </form>

    <!-- Encabezado para la sección de sesiones registradas -->
    <h2>Sesiones</h2>
    <!-- Tabla para mostrar las sesiones registradas -->
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Rutina</th>
                <th>Duración</th>
                <th>Detalle</th>
            </tr>
        </thead>
        <tbody>
            <!-- Comprobar si hay sesiones registradas -->
            <?php if (!empty($data['sesiones'])): ?>
                <!-- Iterar sobre cada sesión y mostrarla en la tabla -->
                <?php foreach ($data['sesiones'] as $sesion): ?>
                    <tr>
                        <!-- Mostrar la fecha, rutina, duración y detalle de cada sesión -->
                        <td><?= htmlspecialchars($sesion['fecha']) ?></td>
                        <td><?= htmlspecialchars($sesion['rutina_nombre']) ?></td>
                        <td><?= htmlspecialchars($sesion['duracion']) ?></td>
                        <td><?= htmlspecialchars($sesion['detalle']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Mostrar un mensaje si no hay sesiones registradas -->
                <tr>
                    <td colspan="4">No hay sesiones registradas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <!-- Formulario para volver -->
    <form method="POST" action="controladorInicio.php" class="centered-button-form">
        <button type="submit" name="accion" value="volver">Volver a selección de opciones</button>
    </form>
</body>
</html>
