<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/torneo.php';

$usuario = require_login($pdo);
$currentPage = 'fixture';
$torneoId = selected_torneo_id();
$torneo = load_torneo($pdo, $torneoId);

$stmt = $pdo->prepare(
    'SELECT partidos.*, local.nombre AS local, visitante.nombre AS visitante
     FROM partidos
     INNER JOIN equipos local ON local.id = partidos.equipo_local_id
     INNER JOIN equipos visitante ON visitante.id = partidos.equipo_visitante_id
     WHERE partidos.torneo_id = ?
     ORDER BY partidos.fecha_numero DESC, partidos.fecha_partido DESC, partidos.id ASC'
);
$stmt->execute([$torneoId]);
$partidosPorFecha = [];

foreach ($stmt->fetchAll() as $partido) {
    $partidosPorFecha[$partido['fecha_numero'] . '|' . $partido['fecha_partido']][] = $partido;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fixture</title>
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
    <div class="match-list">
        <?php if (!$partidosPorFecha): ?>
            <div class="alert">Este torneo todavia no tiene partidos cargados.</div>
        <?php endif; ?>

        <?php foreach ($partidosPorFecha as $key => $partidos): ?>
            <?php [$fechaNumero, $fechaPartido] = explode('|', $key); ?>
            <h2 class="date-title">Fecha <?= (int) $fechaNumero ?> | <?= e(date('d/m/Y', strtotime($fechaPartido))) ?></h2>

            <?php foreach ($partidos as $partido): ?>
                <?php
                $score = $partido['goles_local'] === null || $partido['goles_visitante'] === null
                    ? 'VS'
                    : (int) $partido['goles_local'] . ' - ' . (int) $partido['goles_visitante'];
                ?>
                <article class="match-card">
                    <div class="team-cell">
                        <span class="team-mark"><?= e(substr($partido['local'], 0, 2)) ?></span>
                        <strong><?= e($partido['local']) ?></strong>
                    </div>
                    <div class="score"><?= e($score) ?></div>
                    <div class="team-cell right">
                        <strong><?= e($partido['visitante']) ?></strong>
                        <span class="team-mark"><?= e(substr($partido['visitante'], 0, 2)) ?></span>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
</main>

<?php require __DIR__ . '/includes/nav.php'; ?>
</body>
</html>
