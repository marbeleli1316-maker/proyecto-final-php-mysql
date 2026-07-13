<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/src/functions.php';

$pdo = getDBConnection();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($id) {
    $stmt = $pdo->prepare('DELETE FROM estudiantes WHERE id = ?');
    $stmt->execute([$id]);
}

redirigir('index.php?msg=eliminado');
