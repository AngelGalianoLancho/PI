<div class="container text-center bg-light rounded">
    <!-- Encabezado para el formulario de inicio de sesión -->
    <h1>Iniciar sesión</h1>
    <!-- Formulario para enviar datos al controlador de inicio de sesión -->
    <form action="controladorInicio.php" method="post">
        <!-- Etiqueta y campo de entrada para el correo electrónico -->
        <label for="key" class="form-label"><b>Correo electrónico:</b></label><br>
        <input type="email" class="form-control" id="key" name="correo" required><br>
        <!-- Etiqueta y campo de entrada para la contraseña -->
        <label for="contraseña" class="form-label"><b>Contraseña:</b></label><br>
        <input type="password" class="form-control" id="contraseña" name="contraseña" required><br><br>
        <!-- Botón para enviar el formulario -->
        <button type="submit" class="btn btn-dark">Iniciar sesión</button>
        <!-- Campo oculto para indicar el tipo de usuario -->
        <input type="hidden" name="tipo" value="usuario">
    </form>
    <!-- Párrafo con un enlace para redirigir a la página de registro -->
    <p class="mt-3">¿No tienes una cuenta? <a href="controladorRegistro.php">Regístrate aquí</a></p>
</div>
