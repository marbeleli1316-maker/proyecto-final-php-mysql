<?php
/**
 * config/database.php
 * Conexión segura a MySQL utilizando PDO.
 * Las credenciales se leen de variables de entorno cuando están disponibles
 * (recomendado en producción); si no existen, se usan valores por defecto
 * para desarrollo local.
 */

// Evita mostrar errores de PHP directamente al usuario final en producción
ini_set('display_errors', '0');
error_reporting(E_ALL);

function getDBConnection(): PDO
{
    $host   = getenv('DB_HOST') ?: 'localhost';
    $dbname = getenv('DB_NAME') ?: 'gestion_estudiantes';
    $user   = getenv('DB_USER') ?: 'root';
    $pass   = getenv('DB_PASS') ?: '';
    $port   = getenv('DB_PORT') ?: '3306';

    $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false, // usa sentencias preparadas reales -> previene SQL injection
    ];

    try {
        return new PDO($dsn, $user, $pass, $options);
    } catch (PDOException $e) {
        // No exponemos detalles sensibles de la BD al usuario
        error_log('Error de conexión a la base de datos: ' . $e->getMessage());
        die('No se pudo conectar a la base de datos. Intente más tarde.');
    }
}
