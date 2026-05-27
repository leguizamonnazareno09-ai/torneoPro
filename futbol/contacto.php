<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/torneo.php';

$usuario = require_login($pdo);
$currentPage = 'contacto';
$torneoId = selected_torneo_id();
$torneo = load_torneo($pdo, $torneoId);
$ok = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $mensaje = trim($_POST['mensaje'] ?? '');

    if ($nombre === '' || $email === '' || $telefono === '' || $mensaje === '') {
        $error = 'Completa todos los campos.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Ingresa un email valido.';
    } else {
        $stmt = $pdo->prepare('INSERT INTO mensajes_contacto (nombre, email, telefono, mensaje) VALUES (?, ?, ?, ?)');
        $stmt->execute([$nombre, $email, $telefono, $mensaje]);
        $ok = true;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<div class="header">
    <div class="torneo"><?= e($torneo['nombre']) ?></div>
    <p class="muted">Contacto del torneo | <?= e($torneo['barrio'] ?? '') ?></p>
    <?php if ((int) ($torneo['creador_id'] ?? 0) === (int) $usuario['id']): ?>
        <a class="btn admin-link" href="<?= e(agregar_usuario('administrar_torneo.php?torneo=' . (int) $torneoId, $usuario)) ?>">Administrar torneo</a>
    <?php endif; ?>
</div>

<main class="page">
    <section class="panel">
        <div class="section-title">Datos del torneo</div>
        <div class="form">
            <p><strong>Torneo:</strong> <?= e($torneo['nombre']) ?></p>
            <p><strong>Barrio:</strong> <?= e($torneo['barrio'] ?? 'Sin barrio cargado') ?></p>
            <p><strong>Modalidad:</strong> <?= e($torneo['modalidad'] ?? 'Sin modalidad') ?></p>
            <p><strong>Organizador:</strong> <?= e($torneo['creador_nombre'] ?? 'Sin organizador') ?></p>
            <?php if (!empty($torneo['creador_telefono'])): ?>
                <p><strong>Telefono:</strong> <?= e($torneo['creador_telefono']) ?></p>
            <?php endif; ?>
            <?php if (!empty($torneo['creador_email'])): ?>
                <p><strong>Email:</strong> <a href="mailto:<?= e($torneo['creador_email']) ?>"><?= e($torneo['creador_email']) ?></a></p>
            <?php endif; ?>
        </div>
    </section>

    <?php if ($ok): ?>
        <div class="alert ok">Mensaje guardado correctamente.</div>
    <?php elseif ($error): ?>
        <div class="alert error"><?= e($error) ?></div>
    <?php endif; ?>

    <section class="panel">
        <div class="section-title">Enviar mensaje</div>
        <form class="form" method="post" action="<?= e(agregar_usuario('contacto.php?torneo=' . (int) $torneoId, $usuario)) ?>">
            <input type="hidden" name="usuario" value="<?= (int) $usuario['id'] ?>">
            <label>Nombre completo <input type="text" name="nombre" required></label>
            <label>Correo electronico <input type="email" name="email" required></label>
            <label>Telefono / WhatsApp <input type="tel" name="telefono" required></label>
            <label>Mensaje <textarea name="mensaje" required></textarea></label>
            <button class="btn" type="submit">Enviar mensaje</button>
        </form>
    </section>
</main>

<?php require __DIR__ . '/includes/nav.php'; ?>
</body>
</html>
