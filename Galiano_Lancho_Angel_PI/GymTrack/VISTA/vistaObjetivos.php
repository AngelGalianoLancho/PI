<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Establecer Objetivo</title>
</head>
<body>
    <h1>Establece Objetivos</h1>
    <!-- Formulario para establecer un nuevo objetivo -->
    <form action="controladorObjetivos.php" method="post">
        <!-- Etiqueta y select para seleccionar el tipo de objetivo -->
        <label for="tipo_objetivo">Tipo de Objetivo:</label>
        <select name="tipo_objetivo" id="tipo_objetivo" class="select-box">
            <option value="Perdida de Peso">Pérdida de Peso</option>
            <option value="Aumento de Masa Muscular">Aumento de Masa Muscular</option>
        </select><br><br>
        <!-- Etiqueta y campo de entrada para el peso objetivo -->
        <label for="peso_objetivo">Peso Objetivo:</label>
        <input type="text" name="peso_objetivo" id="peso_objetivo" class="text-input"><br><br>
        <!-- Etiqueta y campo de entrada para la fecha límite -->
        <label for="fecha_limite">Fecha Límite:</label>
        <input type="date" name="fecha_limite" id="fecha_limite" class="date-input"><br><br>
        <!-- Botón para enviar el formulario -->
        <input type="submit" value="Establecer Objetivo">
    </form>

    <!-- Encabezado para la sección de objetivos -->
    <h2>Objetivos</h2>
    <table>
        <thead>
            <tr>
                <th>Tipo de Objetivo</th>
                <th>Peso Objetivo</th>
                <th>Fecha Límite</th>
            </tr>
        </thead>
        <tbody>
            <!-- Comprobar si hay objetivos registrados -->
            <?php if (!empty($data['objetivos'])): ?>
                <!-- Iterar sobre cada objetivo y mostrarlo en la tabla -->
                <?php foreach ($data['objetivos'] as $objetivo): ?>
                    <tr>
                        <!-- Mostrar tipo de objetivo, peso objetivo y fecha límite -->
                        <td><?= htmlspecialchars($objetivo['tipo_objetivo']) ?></td>
                        <td><?= htmlspecialchars($objetivo['peso_objetivo']) ?></td>
                        <!-- Utilizar la función date() para dar formato a la fecha -->
                        <td><?= date('d/m/Y', strtotime($objetivo['fecha_limite'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Mostrar mensaje si no hay objetivos registrados -->
                <tr>
                    <td colspan="3">No hay objetivos registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <!-- Formulario para volver a la selección de opciones -->
    <form method="POST" action="controladorInicio.php">
        <button type="submit" name="accion" value="volver" class="centered-button">Volver a selección de opciones</button>
    </form>
</body>
</html>
