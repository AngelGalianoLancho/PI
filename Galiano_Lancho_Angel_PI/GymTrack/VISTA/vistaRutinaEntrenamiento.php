<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Establecer Rutina de Entrenamiento</title>
    <script>
        // Función para agregar un nuevo ejercicio al formulario
        function agregarEjercicio() {
            var ejerciciosDiv = document.getElementById('ejercicios');
            var ejercicioIndex = ejerciciosDiv.children.length;
            var ejercicioDiv = document.createElement('div');

            // Se crea el contenido HTML del nuevo ejercicio
            ejercicioDiv.innerHTML = `
                <h3>Ejercicio ${ejercicioIndex + 1}</h3>
                <label for="nombre_ejercicio_${ejercicioIndex}">Nombre:</label>
                <input type="text" name="nombre_ejercicio[]" id="nombre_ejercicio_${ejercicioIndex}" required><br>
                <label for="descripcion_ejercicio_${ejercicioIndex}">Descripción:</label>
                <input type="text" name="descripcion_ejercicio[]" id="descripcion_ejercicio_${ejercicioIndex}"><br>
                <label for="repeticiones_${ejercicioIndex}">Repeticiones (separadas por comas):</label>
                <input type="text" name="repeticiones[]" id="repeticiones_${ejercicioIndex}" required><br>
                <label for="kg_${ejercicioIndex}">Peso (kg):</label>
                <input type="text" name="kg[]" id="kg_${ejercicioIndex}" required><br><br>
                <label for="series_${ejercicioIndex}">Series:</label>
                <input type="number" name="series[]" id="series_${ejercicioIndex}" required><br>
            `;
            ejerciciosDiv.appendChild(ejercicioDiv);
        }

        // Función para obtener los ejercicios ingresados y enviarlos al servidor
        function obtenerEjercicios() {
            var ejerciciosDiv = document.getElementById('ejercicios');
            var ejercicios = [];
            for (var i = 0; i < ejerciciosDiv.children.length; i++) {
                var ejercicioDiv = ejerciciosDiv.children[i];
                ejercicios.push({
                    nombre: ejercicioDiv.querySelector(`[name="nombre_ejercicio[]"]`).value,
                    descripcion: ejercicioDiv.querySelector(`[name="descripcion_ejercicio[]"]`).value,
                    repeticiones: ejercicioDiv.querySelector(`[name="repeticiones[]"]`).value,
                    kg: ejercicioDiv.querySelector(`[name="kg[]"]`).value,
                    series: ejercicioDiv.querySelector(`[name="series[]"]`).value
                });
            }
            // Se establece el valor de los ejercicios en un campo oculto para enviarlos al servidor
            document.getElementById('ejercicios_input').value = JSON.stringify(ejercicios);
        }
    </script>
</head>
<body>
    <!-- Encabezado para establecer rutinas de entrenamiento -->
    <h1>Establece Rutinas de Entrenamiento</h1>
    <!-- Formulario para enviar los datos al controlador de rutina -->
    <form action="controladorRutina.php" method="post" onsubmit="obtenerEjercicios()">
        <!-- Campo para el nombre de la rutina -->
        <label for="nombre_rutina">Nombre de la Rutina:</label>
        <input type="text" name="nombre_rutina" id="nombre_rutina" class="text-input" required><br><br>
        <!-- Campo para la descripción de la rutina -->
        <label for="descripcion">Descripción:</label>
        <input type="text" name="descripcion" id="descripcion" class="text-input"><br><br>

        <!-- Encabezado para la sección de ejercicios -->
        <h2>Ejercicios</h2>
        <!-- Contenedor para los ejercicios -->
        <div id="ejercicios"></div>
        <!-- Botón para agregar un nuevo ejercicio -->
        <button type="button" onclick="agregarEjercicio()" class="add-button">Agregar Ejercicio</button><br><br>
        
        <!-- Campo oculto para enviar los ejercicios al servidor -->
        <input type="hidden" name="ejercicios" id="ejercicios_input">
        <!-- Botón de envío del formulario -->
        <input type="submit" value="Establecer Rutina" class="submit-button">
    </form>

    <!-- Encabezado para la sección de rutinas -->
    <h2>Rutinas</h2>
    <!-- Tabla para mostrar las rutinas existentes -->
    <table>
        <thead>
            <tr>
                <th>Nombre de la Rutina</th>
                <th>Descripción</th>
                <th>Ejercicios</th>
            </tr>
        </thead>
        <tbody>
            <!-- Comprobar si hay rutinas registradas -->
            <?php if (!empty($data['rutinas'])): ?>
                <!-- Iterar sobre cada rutina y mostrar sus detalles -->
                <?php foreach ($data['rutinas'] as $rutina): ?>
                    <tr>
                        <td><?= htmlspecialchars($rutina['nombre']) ?></td>
                        <td><?= htmlspecialchars($rutina['descripcion']) ?></td>
                        <td>
                            <!-- Mostrar los ejercicios de la rutina en una lista -->
                            <ul>
                                <?php foreach ($rutina['ejercicios'] as $ejercicio): ?>
                                    <li>
                                        <?= htmlspecialchars($ejercicio['nombre']) ?>:
                                        <?= htmlspecialchars($ejercicio['descripcion']) ?> - 
                                        <?= htmlspecialchars($ejercicio['repeticiones']) ?> repeticiones, 
                                        <?= htmlspecialchars($ejercicio['series']) ?> series,
                                        <?= htmlspecialchars($ejercicio['kg']) ?> kg
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Mostrar un mensaje si no hay rutinas registradas -->
                <tr>
                    <td colspan="3">No hay rutinas registradas.</td>
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
