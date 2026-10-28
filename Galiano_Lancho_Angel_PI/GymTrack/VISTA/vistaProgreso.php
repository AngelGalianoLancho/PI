<div class="container">
    <!-- Encabezado para el formulario de registro de progreso -->
    <h1>Registra el Progreso</h1>
    <!-- Formulario para registrar el progreso -->
    <form action="../CONTROLADOR/controladorProgreso.php" method="post">
        <!-- Etiqueta y campo de entrada para la fecha -->
        <label for="fecha">Fecha:</label>
        <input type="date" name="fecha" id="fecha" required><br><br>
        <!-- Etiqueta y campo de entrada para el peso -->
        <label for="peso">Peso (kg):</label>
        <input type="number" step="0.1" name="peso" id="peso" required><br><br>
        <!-- Etiqueta y campo de entrada para la altura -->
        <label for="altura">Altura (cm) (opcional):</label>
        <input type="number" step="0.1" name="altura" id="altura"><br><br>
        <!-- Etiqueta y campo de entrada para el porcentaje de grasa corporal -->
        <label for="porcentaje_grasa">Porcentaje de Grasa (%):</label>
        <input type="number" step="0.1" name="porcentaje_grasa" id="porcentaje_grasa" required><br><br>
        <!-- Botón para enviar el formulario -->
        <input type="submit" value="Registrar Progreso">
    </form>

    <!-- Encabezado para la sección de progreso -->
    <h2>Progreso</h2>
    <!-- Comprobar si hay registros de progreso -->
    <?php if (isset($data['progreso']) && count($data['progreso']) > 0): ?>
        <!-- Mostrar tabla con registros de progreso -->
        <table border="1">
            <tr>
                <th>Fecha</th>
                <th>Peso (kg)</th>
                <th>Altura (cm)</th>
                <th>Porcentaje de Grasa (%)</th>
            </tr>
            <?php foreach ($data['progreso'] as $progreso): ?>
                <tr>
                    <!-- Mostrar la fecha, peso, altura y porcentaje de grasa de cada registro -->
                    <td><?= date('d/m/Y', strtotime($progreso['fecha'])) ?></td>
                    <td><?= htmlspecialchars($progreso['peso']) ?></td>
                    <td><?= htmlspecialchars($progreso['altura'] ?? 'N/A') ?></td>
                    <td><?= htmlspecialchars($progreso['porcentaje_grasa']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <!-- Mostrar mensaje si no hay registros de progreso -->
        <p>No hay registros de progreso.</p>
    <?php endif; ?>
    <!-- Formulario para volver a la página anterior -->
    <form method="POST" action="controladorInicio.php" class="centered-button-form">
        <button type="submit" name="accion" value="volver">Volver a selección de opciones</button>
    </form>
</div>
