<div class="container text-center bg-light">
    <!-- Encabezado para el formulario de registro de nuevo administrador -->
    <h1>Añadir Nuevo Administrador</h1>
    <!-- Formulario para enviar datos al controlador de inicio de sesión -->
    <form action="controladorLogin.php" method="post" class="needs-validation" novalidate>
        <!-- Campo para el nombre del nuevo administrador -->
        <div class="mb-3">
            <label for="nombre" class="form-label"><b>Nombre:</b></label>
            <input type="name" class="form-control" id="nombre" name="nombre" required>
        </div>
        <!-- Campo para el correo electrónico del nuevo administrador -->
        <div class="mb-3">
            <label for="key" class="form-label"><b>Correo electrónico:</b></label>
            <input type="email" class="form-control" id="key" name="correo" required>
        </div>
        <!-- Campo para la contraseña del nuevo administrador -->
        <div class="mb-3">
            <label for="contraseña" class="form-label"><b>Contraseña:</b></label>
            <input type="password" class="form-control" id="contraseña" name="contraseña" required>
        </div>
        <!-- Botón de envío del formulario -->
        <button type="submit" class="btn btn-dark">Registrarse</button>
        <!-- Campo oculto para indicar el tipo de usuario (administrador) -->
        <input type="hidden" name="tipo" value="administrador">
    </form>
    <!-- Formulario para volver a la selección de opciones -->
    <form method="POST" action="controladorInicio.php">
        <button type="submit" name="accion" value="volver" class="centered-button">Volver a selección de opciones</button>
    </form>
</div>
