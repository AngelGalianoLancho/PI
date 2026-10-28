<div class="container text-center">
    <!-- Encabezado con el nombre de usuario, se espera que $data sea un array asociativo con una clave llamada "key" -->
    <h2>Administrador: <?= $data["key"] ?></h2>
    <!-- Enlace para añadir un nuevo usuario, dirige a "controladorRegistro.php" -->
    <div class="d-flex justify-content-center">
        <a href="controladorRegistro.php" style="margin-right: 250px;">
            <!-- Botón para añadir nuevo administrador -->
            <button class="button">Añadir Nuevo Administrador</button>
        </a>
        <!-- Enlace para visualizar reservas, dirige a "controladorGestionUsuarios.php" -->
        <a href="controladorGestionUsuarios.php">
            <!-- Botón para gestionar usuarios -->
            <button class="button">Gestion Usuarios</button>
        </a>
    </div>
</div>
