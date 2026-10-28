<div class="container text-center">
    <!-- Encabezado de bienvenida que muestra el nombre del usuario obtenido del array $data -->
    <h2>Bienvenido <?= $data["key"] ?></h2>
    <!-- Descripción de la selección de opciones -->
    <p>Selecciona una Opción: </p>
    <div class="text-center d-flex justify-content-center">
        <!-- Formulario para gestionar objetivos, envía datos a "controladorObjetivos.php" -->
        <form action="controladorObjetivos.php" method="post" class="me-2">
            <button type="submit" class="button">Gestionar Objetivos</button>
        </form>
        <!-- Formulario para gestionar rutinas de entrenamiento, envía datos a "controladorRutina.php" -->
        <form action="controladorRutina.php" method="post" style="margin-left: 10px;">
            <button type="submit" class="button">Gestionar Rutinas de Entrenamiento</button>
        </form>
        <!-- Formulario para gestionar sesiones de ejercicios, envía datos a "controladorSesionEjercicio.php" -->
        <form action="controladorSesionEjercicio.php" method="post" style="margin-left: 10px;">
            <button type="submit" class="button">Gestionar Sesiones de Ejercicios</button>
        </form>
        <!-- Formulario para gestionar progresos -->
        <form action="controladorProgreso.php" style="margin-left: 10px;">
            <button type="submit" class="button">Gestionar Progresos</button>
        </form>
    </div>
</div>
