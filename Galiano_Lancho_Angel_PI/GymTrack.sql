-- Creación de la base de datos (si no existe)
CREATE DATABASE IF NOT EXISTS GymTrack;

-- Usar la base de datos creada
USE GymTrack;

-- Creación del usuario y asignación de permisos (si aún no existe)
CREATE USER IF NOT EXISTS 'user_dwes'@'%' IDENTIFIED BY 'userUSER2';
GRANT ALL PRIVILEGES ON GymTrack.* TO 'user_dwes'@'%';
FLUSH PRIVILEGES;

-- Creación de la tabla Usuarios
CREATE TABLE IF NOT EXISTS Usuarios (
    correo VARCHAR(255) PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    contrasena VARCHAR(255) NOT NULL
);

-- Creación de la tabla Administradores
CREATE TABLE IF NOT EXISTS Administradores (
    correo VARCHAR(255) PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    contrasena VARCHAR(255) NOT NULL
);

-- Creación de la tabla Rutinas
CREATE TABLE IF NOT EXISTS Rutinas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion VARCHAR(255),
    usuario_correo VARCHAR(255),
    FOREIGN KEY (usuario_correo) REFERENCES Usuarios(correo)
);

-- Creación de la tabla Ejercicios
CREATE TABLE IF NOT EXISTS Ejercicios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion VARCHAR(255),
    rutina_id INT,
    repeticiones VARCHAR(50),
    kg VARCHAR(50),
    series INT,
    FOREIGN KEY (rutina_id) REFERENCES Rutinas(id)
);

-- Creación de la tabla SesionesEjercicio
CREATE TABLE IF NOT EXISTS SesionesEjercicio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fecha DATE,
    tipo_ejercicio VARCHAR(100),
    duracion TIME,
    detalle VARCHAR(255),
    usuario_correo VARCHAR(255),
    FOREIGN KEY (usuario_correo) REFERENCES Usuarios(correo)
);

-- Creación de la tabla Progreso
CREATE TABLE IF NOT EXISTS Progreso (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fecha DATE,
    peso FLOAT,
    altura FLOAT,
    porcentaje_grasa FLOAT,
    usuario_correo VARCHAR(255),
    FOREIGN KEY (usuario_correo) REFERENCES Usuarios(correo)
);

-- Creación de la tabla Objetivos
CREATE TABLE IF NOT EXISTS Objetivos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_correo VARCHAR(255),
    tipo_objetivo VARCHAR(50),
    peso_objetivo FLOAT,
    fecha_limite DATE,
    FOREIGN KEY (usuario_correo) REFERENCES Usuarios(correo)
);


-- Para usuarios
INSERT INTO Usuarios (correo, nombre, contrasena) VALUES 
('usuario@example.com', 'usuario', '$2y$10$Ewrm/wld9BVYSttNmCicyeMnlBhxK6olVdASdLE0DaPWM6vamt65q');-- contraseña: 1234

-- Para administradores
INSERT INTO Administradores (correo, nombre, contrasena) VALUES 
('administrador@example.com', 'administrador', '$2y$10$Ewrm/wld9BVYSttNmCicyeMnlBhxK6olVdASdLE0DaPWM6vamt65q');-- contraseña: 1234
