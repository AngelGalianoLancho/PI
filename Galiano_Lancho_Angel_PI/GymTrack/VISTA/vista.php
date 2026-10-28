<!-- Contenedor principal -->
<div class="container d-flex flex-column justify-content-center align-items-center bg-light rounded">
    <!-- Sección de bienvenida -->
    <div class="container text-center">
        <h2>Bienvenido a GymTrack</h2>
        <p>Selecciona tu rol:</p>
    </div>
    <!-- Sección de selección de rol -->
    <div class="d-flex justify-content-center">
        <!-- Formulario para el rol de usuario -->
        <form action="CONTROLADOR/controladorRegistro.php" method="post" style="margin-right: 250px;">
            <input type="hidden" name="tipo" value="usuario">
            <button type="submit" class="button">Usuario</button>
        </form>
        <!-- Formulario para el rol de administrador -->
        <form action="CONTROLADOR/controladorLogin.php" method="post">
            <input type="hidden" name="tipo" value="administrador">
            <button type="submit" class="button">Administrador</button>
        </form>
    </div>
</div>
