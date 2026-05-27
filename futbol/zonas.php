<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/torneo.php';

$usuario = require_login($pdo);
$currentPage = 'zonas';
$torneoId = selected_torneo_id();
$torneo = load_torneo($pdo, $torneoId);

$stmt = $pdo->prepare(
    'SELECT *
     FROM equipos
     WHERE torneo_id = ?
     ORDER BY zona ASC, puntos DESC, diferencia_gol DESC, nombre ASC'
);
$stmt->execute([$torneoId]);
$equiposPorZona = [];

foreach ($stmt->fetchAll() as $equipo) {
    $equiposPorZona[$equipo['zona']][] = $equipo;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zonas - <?= e($torneo['nombre']) ?></title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<div class="header">
    <div class="torneo"><?= e($torneo['nombre']) ?></div>
    <p class="muted"><?= e($torneo['barrio'] ?? '') ?> | <?= e($torneo['modalidad'] ?? '') ?></p>
    <?php if (!empty($torneo['creador_nombre'])): ?>
        <p class="muted">Organizado por <?= e($torneo['creador_nombre']) ?></p>
    <?php endif; ?>
    <?php if ((int) ($torneo['creador_id'] ?? 0) === (int) $usuario['id']): ?>
        <a class="btn admin-link" href="<?= e(agregar_usuario('administrar_torneo.php?torneo=' . (int) $torneoId, $usuario)) ?>">Administrar torneo</a>
    <?php endif; ?>
</div>

<main class="page">
    <?php if (!$equiposPorZona): ?>
        <div class="alert">Este torneo todavia no tiene equipos cargados.</div>
    <?php endif; ?>

    <?php foreach ($equiposPorZona as $zona => $equipos): ?>
        <section class="table-card">
            <div class="zona-titulo">Zona <?= e($zona) ?></div>
            <div class="table-wrap">
                <table>
                    <thead>
                    <tr>
                        <th>#</th>
                        <th class="equipo">Equipo</th>
                        <th>J</th>
                        <th>G</th>
                        <th>E</th>
                        <th>P</th>
                        <th>+/-</th>
                        <th>PTS</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($equipos as $index => $equipo): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td class="equipo">
                                <span class="team-cell">
                                    <span class="team-mark"><?= e(substr($equipo['nombre'], 0, 2)) ?></span>
                                    <?= e($equipo['nombre']) ?>
                                </span>
                            </td>
                            <td><?= (int) $equipo['jugados'] ?></td>
                            <td><?= (int) $equipo['ganados'] ?></td>
                            <td><?= (int) $equipo['empatados'] ?></td>
                            <td><?= (int) $equipo['perdidos'] ?></td>
                            <td><?= (int) $equipo['diferencia_gol'] ?></td>
                            <td><strong><?= (int) $equipo['puntos'] ?></strong></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    <?php endforeach; ?>
</main>

<?php require __DIR__ . '/includes/nav.php'; ?>
</body>
</html>
