<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/torneo.php';

$usuario = require_login($pdo);
$currentPage = 'goleadores';
$torneoId = selected_torneo_id();
$torneo = load_torneo($pdo, $torneoId);

$stmt = $pdo->prepare(
    'SELECT jugadores.nombre, jugadores.goles, jugadores.amarillas, jugadores.rojas, equipos.nombre AS equipo
     FROM jugadores
     INNER JOIN equipos ON equipos.id = jugadores.equipo_id
     WHERE equipos.torneo_id = ?
     ORDER BY jugadores.goles DESC, jugadores.rojas ASC, jugadores.amarillas ASC, jugadores.nombre ASC'
);
$stmt->execute([$torneoId]);
$jugadores = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Goleadores</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<div class="header">
    <div class="torneo"><?= e($torneo['nombre'] ?? 'Torneo') ?></div>
    <p class="muted"><?= e($torneo['barrio'] ?? '') ?> | <?= e($torneo['modalidad'] ?? '') ?></p>
    <?php if (!empty($torneo['creador_nombre'])): ?>
        <p class="muted">Organizado por <?= e($torneo['creador_nombre']) ?></p>
    <?php endif; ?>
    <?php if ((int) ($torneo['creador_id'] ?? 0) === (int) $usuario['id']): ?>
        <a class="btn admin-link" href="<?= e(agregar_usuario('administrar_torneo.php?torneo=' . (int) $torneoId, $usuario)) ?>">Administrar torneo</a>
    <?php endif; ?>
</div>

<main class="page">
    <section class="table-card">
        <div class="section-title">Tabla de goleadores</div>
        <div class="table-wrap">
            <table>
                <thead>
                <tr>
                    <th>#</th>
                    <th class="jugador">Jugador</th>
                    <th class="equipo">Equipo</th>
                    <th>G</th>
                    <th>Amarillas</th>
                    <th>Rojas</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($jugadores as $index => $jugador): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td class="jugador"><?= e($jugador['nombre']) ?></td>
                        <td class="equipo"><?= e($jugador['equipo']) ?></td>
                        <td><strong><?= (int) $jugador['goles'] ?></strong></td>
                        <td><?= (int) $jugador['amarillas'] ?></td>
                        <td><?= (int) $jugador['rojas'] ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php if (!$jugadores): ?>
                    <tr><td colspan="6">Este torneo todavia no tiene goleadores cargados.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

<?php require __DIR__ . '/includes/nav.php'; ?>
</body>
</html>
