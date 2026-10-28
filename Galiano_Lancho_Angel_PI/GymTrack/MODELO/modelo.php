<?php
require_once('config.php');
require_once('bbdd.php'); // Requiere archivos de configuración y funciones de base de datos

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL); // Configuración para mostrar errores

// Función para registrar un nuevo usuario o administrador en la base de datos
function registrar($correo, $nombre, $password, $tipo) {
    // echo $correo.' '.$nombre.' '.$password.' '.$tipo;
    try {
        $conexion = crear_conexionPDO(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        if ($tipo == "usuario") {
            $insertQuery = $conexion->prepare("INSERT INTO Usuarios (correo, nombre, contrasena) VALUES (:correo, :nombre, :contrasena)");
        } elseif ($tipo == "administrador") {
            $insertQuery = $conexion->prepare("INSERT INTO Administradores (correo, nombre, contrasena) VALUES (:correo, :nombre, :contrasena)");
        }

        $insertQuery->bindParam(':correo', $correo);
        $insertQuery->bindParam(':nombre', $nombre);
        $insertQuery->bindParam(':contrasena', $hashedPassword);
        $insertQuery->execute();
        return true;
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return false;
    }
}

// Función para iniciar sesión de un usuario o administrador
function iniciarSesion($correo, $nombre, $password, $tipo) {
    try {
        $conexion = crear_conexionPDO(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        if ($tipo == "usuario") {
            $query = $conexion->prepare("SELECT * FROM Usuarios WHERE correo = :correo");
        } elseif ($tipo == "administrador") {
            $query = $conexion->prepare("SELECT * FROM Administradores WHERE correo = :correo");
        }

        $query->bindParam(':correo', $correo);
        $query->execute();
        $resultado = $query->fetch(PDO::FETCH_ASSOC);

        if ($resultado && password_verify($password, $resultado['contrasena'])) {
            $_SESSION["rolUsuario"] = $tipo;
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return false;
    }
}

// Función para registrar el progreso de un usuario (peso, altura, porcentaje de grasa)
function establecerProgreso($correo_usuario, $fecha, $peso, $altura, $porcentaje_grasa) {
    try {
        // Crear una conexión a la base de datos
        $conexion = crear_conexionPDO(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        // Preparar la consulta SQL con parámetros nombrados
        $insertQuery = $conexion->prepare("INSERT INTO Progreso (fecha, peso, altura, porcentaje_grasa, usuario_correo) 
                                           VALUES (:fecha, :peso, :altura, :porcentaje_grasa, :usuario_correo)");

        // Asignar valores a los parámetros de la consulta
        $insertQuery->bindParam(':fecha', $fecha);
        $insertQuery->bindParam(':peso', $peso);
        $insertQuery->bindParam(':altura', $altura);
        $insertQuery->bindParam(':porcentaje_grasa', $porcentaje_grasa);
        $insertQuery->bindParam(':usuario_correo', $correo_usuario);

        // Ejecutar la consulta
        $insertQuery->execute();

        // Indicar que el registro fue exitoso
        return true;
    } catch (PDOException $e) {
        // Indicar que hubo un error en el registro
        return false;
    }
}

// Función para obtener el historial de progreso de un usuario
function obtenerProgreso($correo_usuario) {
    try {
        // Crear una conexión a la base de datos
        $conexion = crear_conexionPDO(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        // Preparar la consulta SQL
        $selectQuery = $conexion->prepare("SELECT fecha, peso, altura, porcentaje_grasa 
                                           FROM Progreso 
                                           WHERE usuario_correo = :usuario_correo 
                                           ORDER BY fecha ASC");

        // Asignar valores a los parámetros de la consulta
        $selectQuery->bindParam(':usuario_correo', $correo_usuario);

        // Ejecutar la consulta
        $selectQuery->execute();

        // Obtener los resultados
        return $selectQuery->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Indicar que hubo un error en la obtención de los datos
        return false;
    }
}

// Función para obtener todos los usuarios registrados en la base de datos
function obtenerUsuarios() {
    try {
        $conexion = crear_conexionPDO(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        $query = $conexion->prepare("SELECT * FROM Usuarios");
        $query->execute();
        
        return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

// Función para eliminar un usuario de la base de datos
function eliminarUsuario($correo_usuario) {
    try {
        $conexion = crear_conexionPDO(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        // Eliminar primero registros relacionados en la tabla Progreso (si existe relación)
        $queryProgreso = $conexion->prepare("DELETE FROM Progreso WHERE usuario_correo = :correo");
        $queryProgreso->bindParam(':correo', $correo_usuario, PDO::PARAM_STR);
        $queryProgreso->execute();

        // Eliminar primero registros relacionados en la tabla SesionesEjercicio (si existe relación)
        $querySesiones = $conexion->prepare("DELETE FROM SesionesEjercicio WHERE usuario_correo = :correo");
        $querySesiones->bindParam(':correo', $correo_usuario, PDO::PARAM_STR);
        $querySesiones->execute();

        // Eliminar primero registros relacionados en la tabla Objetivos (si existe relación)
        $queryObjetivos = $conexion->prepare("DELETE FROM Objetivos WHERE usuario_correo = :correo");
        $queryObjetivos->bindParam(':correo', $correo_usuario, PDO::PARAM_STR);
        $queryObjetivos->execute();

        // Eliminar registros relacionados en la tabla Rutinas y luego Ejercicios
        $queryEjercicios = $conexion->prepare("DELETE FROM Ejercicios WHERE rutina_id IN (SELECT id FROM Rutinas WHERE usuario_correo = :correo)");
        $queryEjercicios->bindParam(':correo', $correo_usuario, PDO::PARAM_STR);
        $queryEjercicios->execute();

        $queryRutinas = $conexion->prepare("DELETE FROM Rutinas WHERE usuario_correo = :correo");
        $queryRutinas->bindParam(':correo', $correo_usuario, PDO::PARAM_STR);
        $queryRutinas->execute();

        // Ahora eliminar el usuario
        $queryUsuario = $conexion->prepare("DELETE FROM Usuarios WHERE correo = :correo");
        $queryUsuario->bindParam(':correo', $correo_usuario, PDO::PARAM_STR);
        $queryUsuario->execute();

        return ($queryUsuario->rowCount() > 0);
    } catch (PDOException $e) {
        error_log("Error al eliminar usuario: " . $e->getMessage());
        return false;
    }
}

// Función para actualizar los datos de un usuario (nombre, contraseña, progreso)
function actualizarUsuario($correo_usuario, $nombre_usuario, $contrasena_usuario, $progreso_usuario) {
    try {
        $conexion = crear_conexionPDO(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        // Actualizar datos del usuario
        $updateQuery = "UPDATE Usuarios SET nombre = :nombre";
        if (!empty($contrasena_usuario)) {
            $updateQuery .= ", contrasena = :contrasena";
        }
        $updateQuery .= " WHERE correo = :correo";

        $query = $conexion->prepare($updateQuery);
        $query->bindParam(':correo', $correo_usuario);
        $query->bindParam(':nombre', $nombre_usuario);

        if (!empty($contrasena_usuario)) {
            $contrasena_hash = password_hash($contrasena_usuario, PASSWORD_DEFAULT);
            $query->bindParam(':contrasena', $contrasena_hash);
        }

        $query->execute();

        // Verificar que $progreso_usuario es un array y tiene las claves necesarias
        if (is_array($progreso_usuario) && isset($progreso_usuario['peso'], $progreso_usuario['altura'], $progreso_usuario['porcentaje_grasa'])) {
            $query = $conexion->prepare("UPDATE Progreso SET peso = :peso, altura = :altura, porcentaje_grasa = :porcentaje_grasa WHERE usuario_correo = :correo");
            $query->bindParam(':correo', $correo_usuario);
            $query->bindParam(':peso', $progreso_usuario['peso']);
            $query->bindParam(':altura', $progreso_usuario['altura']);
            $query->bindParam(':porcentaje_grasa', $progreso_usuario['porcentaje_grasa']);
            $query->execute();
        }

        return true;
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
        return false;
    }
}

// Función para registrar una sesión de ejercicio realizada por un usuario
function registrarSesionEjercicio($correo_usuario, $fecha, $tipo_ejercicio, $duracion, $detalle) {
    try {
        $conexion = crear_conexionPDO(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $insertQuery = $conexion->prepare("INSERT INTO SesionesEjercicio (fecha, tipo_ejercicio, duracion, detalle, usuario_correo) 
                                           VALUES (:fecha, :tipo_ejercicio, :duracion, :detalle, :correo_usuario)");
        $insertQuery->bindParam(':fecha', $fecha);
        $insertQuery->bindParam(':tipo_ejercicio', $tipo_ejercicio);
        $insertQuery->bindParam(':duracion', $duracion);
        $insertQuery->bindParam(':detalle', $detalle);
        $insertQuery->bindParam(':correo_usuario', $correo_usuario);
        $insertQuery->execute();
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

// Función para obtener el historial de sesiones de ejercicio de un usuario
function obtenerHistorialSesiones($correo_usuario) {
    try {
        $conexion = crear_conexionPDO(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $query = $conexion->prepare(
            "SELECT se.fecha, r.nombre as rutina_nombre, se.duracion, se.detalle 
             FROM SesionesEjercicio se
             JOIN Rutinas r ON se.tipo_ejercicio = r.id
             WHERE se.usuario_correo = :correo_usuario
             ORDER BY se.fecha DESC"
        );
        $query->bindParam(':correo_usuario', $correo_usuario);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}


// Función para establecer un nuevo objetivo de entrenamiento para un usuario
function establecerObjetivo($correo_usuario, $tipo_objetivo, $peso_objetivo, $fecha_limite) {
    try {
        $conexion = crear_conexionPDO(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $insertQuery = $conexion->prepare("INSERT INTO Objetivos (usuario_correo, tipo_objetivo, peso_objetivo, fecha_limite) 
                                           VALUES (:correo_usuario, :tipo_objetivo, :peso_objetivo, :fecha_limite)");
        $insertQuery->bindParam(':correo_usuario', $correo_usuario);
        $insertQuery->bindParam(':tipo_objetivo', $tipo_objetivo);
        $insertQuery->bindParam(':peso_objetivo', $peso_objetivo);
        $insertQuery->bindParam(':fecha_limite', $fecha_limite);
        $insertQuery->execute();
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

// Función para obtener el historial de objetivos de entrenamiento de un usuario
function obtenerHistorialObjetivos($correo_usuario) {
    try {
        $conexion = crear_conexionPDO(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $query = $conexion->prepare("SELECT * FROM Objetivos WHERE usuario_correo = :correo_usuario ORDER BY fecha_limite DESC");
        $query->bindParam(':correo_usuario', $correo_usuario);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

// Función para establecer una nueva rutina de entrenamiento para un usuario
function establecerRutinaEntrenamiento($usuario_correo, $nombre_rutina, $descripcion, $ejercicios) {
    try {
        $conexion = crear_conexionPDO(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        // Iniciar una transacción
        $conexion->beginTransaction();

        // Insertar la rutina
        $query = $conexion->prepare(
            "INSERT INTO Rutinas (usuario_correo, nombre, descripcion) VALUES (:usuario_correo, :nombre, :descripcion)"
        );
        $query->bindParam(':usuario_correo', $usuario_correo);
        $query->bindParam(':nombre', $nombre_rutina);
        $query->bindParam(':descripcion', $descripcion);
        $query->execute();

        // Obtener el ID de la rutina recién insertada
        $rutina_id = $conexion->lastInsertId();

        // Insertar los ejercicios
        $query = $conexion->prepare(
            "INSERT INTO Ejercicios (rutina_id, nombre, descripcion, repeticiones, kg, series) VALUES (:rutina_id, :nombre, :descripcion, :repeticiones, :kg, :series)"
        );
        foreach ($ejercicios as $ejercicio) {
            $query->bindParam(':rutina_id', $rutina_id);
            $query->bindParam(':nombre', $ejercicio['nombre']);
            $query->bindParam(':descripcion', $ejercicio['descripcion']);
            $query->bindParam(':repeticiones', $ejercicio['repeticiones']); // Guardar repeticiones como texto
            $query->bindParam(':kg', $ejercicio['kg']);
            $query->bindParam(':series', $ejercicio['series']);
            $query->execute();
        }

        // Confirmar la transacción
        $conexion->commit();
        return true;
    } catch (PDOException $e) {
        // En caso de error, deshacer la transacción
        $conexion->rollBack();
        return false;
    }
}



// Función para obtener el historial de rutinas de un usuario
function obtenerHistorialRutinas($correo_usuario) {
    try {
        $conexion = crear_conexionPDO(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $query = $conexion->prepare("SELECT * FROM Rutinas WHERE usuario_correo = :correo_usuario ORDER BY id DESC");
        $query->bindParam(':correo_usuario', $correo_usuario);
        $query->execute();
        $rutinas = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rutinas as &$rutina) {
            $query = $conexion->prepare("SELECT * FROM Ejercicios WHERE rutina_id = :rutina_id");
            $query->bindParam(':rutina_id', $rutina['id']);
            $query->execute();
            $rutina['ejercicios'] = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return $rutinas;
    } catch (PDOException $e) {
        return [];
    }
}


function obtenerRutinas($correo_usuario) {
    try {
        $conexion = crear_conexionPDO(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $query = $conexion->prepare("SELECT id, nombre FROM Rutinas WHERE usuario_correo = :correo_usuario ORDER BY nombre ASC");
        $query->bindParam(':correo_usuario', $correo_usuario);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}
?>