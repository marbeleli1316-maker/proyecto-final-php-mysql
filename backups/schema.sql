-- =========================================================
-- Proyecto Final - Sistema de Gestión de Estudiantes y Notas
-- Script de creación de base de datos
-- =========================================================

CREATE DATABASE IF NOT EXISTS gestion_estudiantes
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE gestion_estudiantes;

CREATE TABLE IF NOT EXISTS estudiantes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cedula VARCHAR(10) NOT NULL UNIQUE,
    nombres VARCHAR(80) NOT NULL,
    apellidos VARCHAR(80) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    carrera VARCHAR(100) NOT NULL,
    semestre TINYINT UNSIGNED NOT NULL,
    nota_final DECIMAL(4,2) NOT NULL DEFAULT 0.00,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT chk_semestre CHECK (semestre BETWEEN 1 AND 10),
    CONSTRAINT chk_nota CHECK (nota_final BETWEEN 0 AND 10)
);

-- Datos de ejemplo (opcional, se pueden borrar)
INSERT INTO estudiantes (cedula, nombres, apellidos, email, carrera, semestre, nota_final) VALUES
('1712345678', 'María José', 'Cevallos Ortiz', 'maria.cevallos@example.com', 'Ingeniería en Software', 5, 8.75),
('1798765432', 'Carlos Andrés', 'Pillajo Mora', 'carlos.pillajo@example.com', 'Ingeniería en Software', 3, 7.40),
('1723456789', 'Andrea Belén', 'Sánchez López', 'andrea.sanchez@example.com', 'Ingeniería en Sistemas', 7, 9.10);
