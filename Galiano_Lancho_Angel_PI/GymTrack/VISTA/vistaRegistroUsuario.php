<div class="container text-center bg-light">
    <!-- Encabezado para el formulario de registro -->
    <h1>Regístrate</h1>
    <!-- Formulario de registro -->
    <form action="controladorLogin.php" method="post" class="needs-validation" novalidate>
        <!-- Campo para el nombre del usuario -->
        <div class="mb-3">
            <label for="nombre" class="form-label"><b>Nombre:</b></label>
            <input type="name" class="form-control" id="nombre" name="nombre" required>
        </div>
        <!-- Campo para el correo electrónico del usuario -->
        <div class="mb-3">
            <label for="key" class="form-label"><b>Correo electrónico:</b></label>
            <input type="email" class="form-control" id="key" name="correo" required>
        </div>
        <!-- Campo para la contraseña del usuario -->
        <div class="mb-3">
            <label for="contraseña" class="form-label"><b>Contraseña:</b></label>
            <input type="password" class="form-control" id="contraseña" name="contraseña" required>
        </div>
        <!-- Botón de envío del formulario -->
        <button type="submit" class="btn btn-dark">Registrarse</button>
        <!-- Campo oculto para indicar el rol del usuario (usuario) -->
        <input type="hidden" name="rolUsuario" value="usuario">
    </form>
    <!-- Enlace para iniciar sesión -->
    <p class="mt-3">¿Ya tienes una cuenta? <a href="controladorLogin.php" class="btn btn-link">Inicia sesión aquí</a></p>
</div>
