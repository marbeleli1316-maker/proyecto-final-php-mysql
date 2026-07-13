<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/src/functions.php';

$pdo = getDBConnection();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id && isset($_POST['id'])) {
    $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
}
if (!$id) {
    redirigir('index.php');
}

$stmtGet = $pdo->prepare('SELECT * FROM estudiantes WHERE id = ?');
$stmtGet->execute([$id]);
$estudiante = $stmtGet->fetch();

if (!$estudiante) {
    redirigir('index.php');
}

$errores = [];
$datos = $estudiante;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = [
        'cedula'     => trim($_POST['cedula'] ?? ''),
        'nombres'    => trim($_POST['nombres'] ?? ''),
        'apellidos'  => trim($_POST['apellidos'] ?? ''),
        'email'      => trim($_POST['email'] ?? ''),
        'carrera'    => trim($_POST['carrera'] ?? ''),
        'semestre'   => trim($_POST['semestre'] ?? ''),
        'nota_final' => trim($_POST['nota_final'] ?? ''),
    ];

    $errores = validarEstudiante($datos);

    if (empty($errores)) {
        // Verificar que cédula/correo no pertenezcan a OTRO estudiante
        $check = $pdo->prepare('SELECT COUNT(*) FROM estudiantes WHERE (cedula = ? OR email = ?) AND id != ?');
        $check->execute([$datos['cedula'], $datos['email'], $id]);
        if ($check->fetchColumn() > 0) {
            $errores['general'] = 'Ya existe otro estudiante registrado con esa cédula o correo electrónico.';
        }
    }

    if (empty($errores)) {
        $stmt = $pdo->prepare(
            'UPDATE estudiantes
             SET cedula = :cedula, nombres = :nombres, apellidos = :apellidos, email = :email,
                 carrera = :carrera, semestre = :semestre, nota_final = :nota_final
             WHERE id = :id'
        );
        $stmt->execute([
            ':cedula'     => $datos['cedula'],
            ':nombres'    => $datos['nombres'],
            ':apellidos'  => $datos['apellidos'],
            ':email'      => $datos['email'],
            ':carrera'    => $datos['carrera'],
            ':semestre'   => (int)$datos['semestre'],
            ':nota_final' => (float)$datos['nota_final'],
            ':id'         => $id,
        ]);

        redirigir('index.php?msg=actualizado');
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Estudiante - Proyecto Final</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <header class="app-header">
        <h1>📚 Sistema de Gestión de Estudiantes y Notas</h1>
        <p>Editar información del estudiante</p>
    </header>

    <main>
        <div class="card">
            <?php if (!empty($errores['general'])): ?>
                <div class="alert alert-danger"><?= limpiar($errores['general']) ?></div>
            <?php endif; ?>

            <form id="form-estudiante" method="POST" novalidate>
                <input type="hidden" name="id" value="<?= (int)$id ?>">

                <div class="field">
                    <label for="cedula">Cédula</label>
                    <input type="text" id="cedula" name="cedula" maxlength="10" pattern="\d{10}"
                           value="<?= limpiar($datos['cedula']) ?>" required>
                    <span class="error-text" id="error-cedula"><?= limpiar($errores['cedula'] ?? '') ?></span>
                </div>

                <div class="field">
                    <label for="nombres">Nombres</label>
                    <input type="text" id="nombres" name="nombres" maxlength="80"
                           value="<?= limpiar($datos['nombres']) ?>" required>
                    <span class="error-text" id="error-nombres"><?= limpiar($errores['nombres'] ?? '') ?></span>
                </div>

                <div class="field">
                    <label for="apellidos">Apellidos</label>
                    <input type="text" id="apellidos" name="apellidos" maxlength="80"
                           value="<?= limpiar($datos['apellidos']) ?>" required>
                    <span class="error-text" id="error-apellidos"><?= limpiar($errores['apellidos'] ?? '') ?></span>
                </div>

                <div class="field">
                    <label for="email">Correo electrónico</label>
                    <input type="email" id="email" name="email" maxlength="120"
                           value="<?= limpiar($datos['email']) ?>" required>
                    <span class="error-text" id="error-email"><?= limpiar($errores['email'] ?? '') ?></span>
                </div>

                <div class="field">
                    <label for="carrera">Carrera</label>
                    <input type="text" id="carrera" name="carrera" maxlength="100"
                           value="<?= limpiar($datos['carrera']) ?>" required>
                    <span class="error-text" id="error-carrera"><?= limpiar($errores['carrera'] ?? '') ?></span>
                </div>

                <div class="field">
                    <label for="semestre">Semestre (1-10)</label>
                    <input type="number" id="semestre" name="semestre" min="1" max="10"
                           value="<?= limpiar((string)$datos['semestre']) ?>" required>
                    <span class="error-text" id="error-semestre"><?= limpiar($errores['semestre'] ?? '') ?></span>
                </div>

                <div class="field">
                    <label for="nota_final">Nota Final (0-10)</label>
                    <input type="number" id="nota_final" name="nota_final" min="0" max="10" step="0.01"
                           value="<?= limpiar((string)$datos['nota_final']) ?>" required>
                    <span class="error-text" id="error-nota_final"><?= limpiar($errores['nota_final'] ?? '') ?></span>
                </div>

                <button type="submit" class="btn btn-primary">Actualizar Estudiante</button>
                <a href="index.php" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </main>

    <footer>Proyecto Final &middot; Desarrollo de Aplicación Web con PHP y MySQL</footer>
    <script src="public/js/validation.js"></script>
</body>
</html>
