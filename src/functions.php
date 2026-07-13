<?php
/**
 * src/functions.php
 * Funciones de validación y utilidades del backend (segunda capa de validación).
 */

/**
 * Valida los datos de un estudiante.
 * Devuelve un arreglo de errores (vacío si todo es válido).
 */
function validarEstudiante(array $data): array
{
    $errores = [];

    // Cédula: exactamente 10 dígitos numéricos
    if (empty($data['cedula']) || !preg_match('/^\d{10}$/', $data['cedula'])) {
        $errores['cedula'] = 'La cédula debe tener exactamente 10 dígitos numéricos.';
    }

    // Nombres
    if (empty(trim($data['nombres'] ?? ''))) {
        $errores['nombres'] = 'El nombre es obligatorio.';
    } elseif (longitudTexto(trim($data['nombres'])) > 80) {
        $errores['nombres'] = 'El nombre no puede superar 80 caracteres.';
    }

    // Apellidos
    if (empty(trim($data['apellidos'] ?? ''))) {
        $errores['apellidos'] = 'El apellido es obligatorio.';
    } elseif (longitudTexto(trim($data['apellidos'])) > 80) {
        $errores['apellidos'] = 'El apellido no puede superar 80 caracteres.';
    }

    // Email
    if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errores['email'] = 'Debe ingresar un correo electrónico válido.';
    }

    // Carrera
    if (empty(trim($data['carrera'] ?? ''))) {
        $errores['carrera'] = 'La carrera es obligatoria.';
    }

    // Semestre: entero entre 1 y 10
    if (!isset($data['semestre']) || !ctype_digit((string)$data['semestre']) ||
        (int)$data['semestre'] < 1 || (int)$data['semestre'] > 10) {
        $errores['semestre'] = 'El semestre debe ser un número entre 1 y 10.';
    }

    // Nota final: decimal entre 0 y 10
    if (!isset($data['nota_final']) || !is_numeric($data['nota_final']) ||
        (float)$data['nota_final'] < 0 || (float)$data['nota_final'] > 10) {
        $errores['nota_final'] = 'La nota debe ser un valor numérico entre 0 y 10.';
    }

    return $errores;
}

/** Longitud de texto segura: usa mb_strlen si la extensión mbstring está disponible */
function longitudTexto(string $valor): int
{
    return function_exists('mb_strlen') ? mb_strlen($valor) : strlen($valor);
}

/** Limpia una cadena de texto contra espacios y etiquetas HTML */
function limpiar(string $valor): string
{
    return htmlspecialchars(trim($valor), ENT_QUOTES, 'UTF-8');
}

/** Redirige a una URL y detiene la ejecución */
function redirigir(string $url): void
{
    header("Location: {$url}");
    exit;
}
