<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/auth.php';

$usuario = require_login($pdo);

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $barrio = trim($_POST['barrio'] ?? '');
    $modalidad = trim($_POST['modalidad'] ?? '');
    $temporada = trim($_POST['temporada'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');

    if ($nombre === '' || $barrio === '' || $modalidad === '' || $temporada === '') {
        $error = 'Completa nombre, barrio, modalidad y temporada.';
    } else {
        $stmt = $pdo->prepare(
            'INSERT INTO torneos (nombre, modalidad, temporada, barrio, descripcion, creador_id, activo)
             VALUES (?, ?, ?, ?, ?, ?, 1)'
        );
        $stmt->execute([$nombre, $modalidad, $temporada, $barrio, $descripcion, (int) $usuario['id']]);

        header('Location: administrar_torneo.php?torneo=' . (int) $pdo->lastInsertId() . '&usuario=' . (int) $usuario['id']);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear torneo</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<header class="topbar">
    <a class="brand" href="<?= e(agregar_usuario('index.php', $usuario)) ?>">
        <img src="img/logo.jpeg" alt="Torneos de Barrio">
        <span><strong>Torneos de Barrio</strong><span>Crear torneo comunitario</span></span>
    </a>
    <div class="actions">
        <span class="session-name">Hola, <?= e($usuario['nombre']) ?></span>
        <a class="btn secondary" href="<?= e(agregar_usuario('index.php', $usuario)) ?>">Volver</a>
    </div>
</header>

<main class="page narrow">
    <section class="panel">
        <div class="section-title">Crear torneo barrial</div>
        <form class="form" method="post" action="<?= e(agregar_usuario('crear_torneo.php', $usuario)) ?>">
            <input type="hidden" name="usuario" value="<?= (int) $usuario['id'] ?>">
            <?php if ($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>
            <label>Nombre del torneo <input type="text" name="nombre" placeholder="Ej: Copa Plaza Mitre" required></label>
            <label>Barrio o zona <input type="text" name="barrio" placeholder="Ej: Villa Urquiza" required></label>
            <label>Modalidad <input type="text" name="modalidad" placeholder="Ej: F5, F6, F7, F11" required></label>
            <label>Temporada <input type="text" name="temporada" placeholder="Ej: Invierno 2026" required></label>
            <label>Descripcion <textarea name="descripcion" placeholder="Contale a la comunidad de que se trata el torneo"></textarea></label>
            <button class="btn" type="submit">Publicar torneo</button>
        </form>
    </section>
</main>
</body>
</html>
