<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/src/functions.php';

$pdo = getDBConnection();
$stmt = $pdo->query('SELECT * FROM estudiantes ORDER BY apellidos, nombres');
$estudiantes = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Estudiantes - Proyecto Final</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <header class="app-header">
        <h1>📚 Sistema de Gestión de Estudiantes y Notas</h1>
        <p>Proyecto Final &middot; PHP + MySQL + PDO</p>
    </header>

    <main>
        <?php if (isset($_GET['msg'])): ?>
            <div class="alert alert-success">
                <?php
                    $mensajes = [
                        'creado'      => 'Estudiante registrado correctamente.',
                        'actualizado' => 'Estudiante actualizado correctamente.',
                        'eliminado'   => 'Estudiante eliminado correctamente.',
                    ];
                    echo $mensajes[$_GET['msg']] ?? 'Operación realizada.';
                ?>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="toolbar">
                <h2 style="margin:0;">Listado de Estudiantes (<?= count($estudiantes) ?>)</h2>
                <a href="create.php" class="btn btn-primary">+ Nuevo Estudiante</a>
            </div>

            <?php if (count($estudiantes) === 0): ?>
                <div class="empty-state">No hay estudiantes registrados todavía.</div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Cédula</th>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Correo</th>
                            <th>Carrera</th>
                            <th>Sem.</th>
                            <th>Nota</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($estudiantes as $e): ?>
                        <tr>
                            <td><?= limpiar($e['cedula']) ?></td>
                            <td><?= limpiar($e['nombres']) ?></td>
                            <td><?= limpiar($e['apellidos']) ?></td>
                            <td><?= limpiar($e['email']) ?></td>
                            <td><?= limpiar($e['carrera']) ?></td>
                            <td><?= (int)$e['semestre'] ?></td>
                            <td>
                                <span class="badge <?= $e['nota_final'] >= 7 ? 'badge-success' : 'badge-danger' ?>">
                                    <?= number_format((float)$e['nota_final'], 2) ?>
                                </span>
                            </td>
                            <td class="actions-cell">
                                <a class="btn btn-secondary btn-sm" href="edit.php?id=<?= (int)$e['id'] ?>">Editar</a>
                                <a class="btn btn-danger btn-sm"
                                   href="delete.php?id=<?= (int)$e['id'] ?>"
                                   onclick="return confirmarEliminacion('<?= limpiar($e['nombres'] . ' ' . $e['apellidos']) ?>')">
                                   Eliminar
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </main>

    <footer>Proyecto Final &middot; Desarrollo de Aplicación Web con PHP y MySQL</footer>
    <script src="public/js/validation.js"></script>
</body>
</html>
