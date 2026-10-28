<!-- Este div contiene toda la sección de inicio de sesión. Tiene un estilo de diseño de contenedor con texto centrado, fondo claro y esquinas redondeadas. -->
<div class="container text-center bg-light rounded">
    <!-- Encabezado para la sección de inicio de sesión -->
    <h1>Iniciar sesión</h1>
    <!-- Formulario para enviar los datos de inicio de sesión al controlador correspondiente. -->
    <form action="controladorInicio.php" method="post">
        <!-- Etiqueta y campo de entrada para el nombre de usuario. -->
        <label for="nombre" class="form-label"><b>Nombre:</b></label>
        <input type="name" class="form-control" id="nombre" name="nombre"><br>
        
        <!-- Etiqueta y campo de entrada para el correo electrónico. -->
        <label for="key" class="form-label"><b>Correo electrónico:</b></label><br>
        <input type="email" class="form-control" id="key" name="correo" required><br>
        
        <!-- Etiqueta y campo de entrada para la contraseña. -->
        <label for="contraseña" class="form-label"><b>Contraseña:</b></label><br>
        <input type="password" class="form-control" id="contraseña" name="contraseña" required><br><br>
        
        <!-- Botón de envío para iniciar sesión, con estilo oscuro. -->
        <button type="submit" class="btn btn-dark ">Iniciar sesión</button>
        
        <!-- Campo oculto para enviar el tipo de usuario (administrador en este caso) -->
        <input type="hidden" name="tipo" value="administrador">
    </form>
</div>
