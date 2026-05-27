<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/torneo.php';

$usuario = require_login($pdo);
$currentPage = 'admin';
$torneoId = selected_torneo_id();
$torneo = load_torneo($pdo, $torneoId);
require_torneo_owner($torneo, $usuario);

$ok = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';

    if ($accion === 'equipo') {
        $nombre = trim($_POST['nombre'] ?? '');
        $zona = strtoupper(trim($_POST['zona'] ?? 'A'));
        $jugados = max(0, (int) ($_POST['jugados'] ?? 0));
        $ganados = max(0, (int) ($_POST['ganados'] ?? 0));
        $empatados = max(0, (int) ($_POST['empatados'] ?? 0));
        $perdidos = max(0, (int) ($_POST['perdidos'] ?? 0));
        $diferenciaGol = (int) ($_POST['diferencia_gol'] ?? 0);
        $puntos = max(0, (int) ($_POST['puntos'] ?? 0));

        if ($nombre === '' || $zona === '') {
            $error = 'Completa nombre del equipo y zona.';
        } else {
            $stmt = $pdo->prepare(
                'INSERT INTO equipos (torneo_id, zona, nombre, jugados, ganados, empatados, perdidos, diferencia_gol, puntos)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
            );
            $stmt->execute([$torneoId, $zona, $nombre, $jugados, $ganados, $empatados, $perdidos, $diferenciaGol, $puntos]);
            $ok = 'Equipo cargado.';
        }
    }

    if ($accion === 'goleador') {
        $equipoId = (int) ($_POST['equipo_id'] ?? 0);
        $nombre = trim($_POST['nombre'] ?? '');
        $goles = max(0, (int) ($_POST['goles'] ?? 0));
        $amarillas = max(0, (int) ($_POST['amarillas'] ?? 0));
        $rojas = max(0, (int) ($_POST['rojas'] ?? 0));

        $check = $pdo->prepare('SELECT id FROM equipos WHERE id = ? AND torneo_id = ?');
        $check->execute([$equipoId, $torneoId]);

        if (!$check->fetch() || $nombre === '') {
            $error = 'Selecciona un equipo valido y carga el nombre del jugador.';
        } else {
            $stmt = $pdo->prepare(
                'INSERT INTO jugadores (equipo_id, nombre, goles, amarillas, rojas)
                 VALUES (?, ?, ?, ?, ?)'
            );
            $stmt->execute([$equipoId, $nombre, $goles, $amarillas, $rojas]);
            $ok = 'Goleador cargado.';
        }
    }

    if ($accion === 'partido') {
        $fechaNumero = max(1, (int) ($_POST['fecha_numero'] ?? 1));
        $fechaPartido = trim($_POST['fecha_partido'] ?? '');
        $localId = (int) ($_POST['equipo_local_id'] ?? 0);
        $visitanteId = (int) ($_POST['equipo_visitante_id'] ?? 0);
        $golesLocal = trim($_POST['goles_local'] ?? '');
        $golesVisitante = trim($_POST['goles_visitante'] ?? '');
        $golesLocal = $golesLocal === '' ? null : max(0, (int) $golesLocal);
        $golesVisitante = $golesVisitante === '' ? null : max(0, (int) $golesVisitante);

        $check = $pdo->prepare('SELECT COUNT(*) FROM equipos WHERE torneo_id = ? AND id IN (?, ?)');
        $check->execute([$torneoId, $localId, $visitanteId]);

        if ($fechaPartido === '' || $localId === $visitanteId || (int) $check->fetchColumn() !== 2) {
            $error = 'Carga fecha y dos equipos distintos del torneo.';
        } else {
            $stmt = $pdo->prepare(
                'INSERT INTO partidos (torneo_id, fecha_numero, fecha_partido, equipo_local_id, equipo_visitante_id, goles_local, goles_visitante)
                 VALUES (?, ?, ?, ?, ?, ?, ?)'
            );
            $stmt->execute([$torneoId, $fechaNumero, $fechaPartido, $localId, $visitanteId, $golesLocal, $golesVisitante]);
            $ok = 'Partido cargado.';
        }
    }
}

$equiposStmt = $pdo->prepare('SELECT * FROM equipos WHERE torneo_id = ? ORDER BY zona ASC, nombre ASC');
$equiposStmt->execute([$torneoId]);
$equipos = $equiposStmt->fetchAll();

$jugadoresStmt = $pdo->prepare(
    'SELECT jugadores.*, equipos.nombre AS equipo
     FROM jugadores
     INNER JOIN equipos ON equipos.id = jugadores.equipo_id
     WHERE equipos.torneo_id = ?
     ORDER BY jugadores.goles DESC, jugadores.nombre ASC'
);
$jugadoresStmt->execute([$torneoId]);
$jugadores = $jugadoresStmt->fetchAll();

$partidosStmt = $pdo->prepare(
    'SELECT partidos.*, local.nombre AS local, visitante.nombre AS visitante
     FROM partidos
     INNER JOIN equipos local ON local.id = partidos.equipo_local_id
     INNER JOIN equipos visitante ON visitante.id = partidos.equipo_visitante_id
     WHERE partidos.torneo_id = ?
     ORDER BY partidos.fecha_numero DESC, partidos.fecha_partido DESC'
);
$partidosStmt->execute([$torneoId]);
$partidos = $partidosStmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar torneo</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<header class="topbar">
    <a class="brand" href="<?= e(agregar_usuario('index.php', $usuario)) ?>">
        <img src="img/logo.jpeg" alt="Torneos de Barrio">
        <span><strong><?= e($torneo['nombre']) ?></strong><span>Panel del creador</span></span>
    </a>
    <div class="actions">
        <a class="btn secondary" href="<?= e(agregar_usuario('zonas.php?torneo=' . (int) $torneoId, $usuario)) ?>">Ver torneo</a>
        <a class="btn secondary" href="<?= e(agregar_usuario('index.php', $usuario)) ?>">Inicio</a>
    </div>
</header>

<main class="page admin-grid">
    <?php if ($ok): ?><div class="alert ok full-row"><?= e($ok) ?></div><?php endif; ?>
    <?php if ($error): ?><div class="alert error full-row"><?= e($error) ?></div><?php endif; ?>

    <section class="panel">
        <div class="section-title">Cargar equipo / zona</div>
        <form class="form compact-form" method="post" action="<?= e(agregar_usuario('administrar_torneo.php?torneo=' . (int) $torneoId, $usuario)) ?>">
            <input type="hidden" name="usuario" value="<?= (int) $usuario['id'] ?>">
            <input type="hidden" name="accion" value="equipo">
            <label>Equipo <input type="text" name="nombre" required></label>
            <label>Zona <input type="text" name="zona" value="A" maxlength="2" required></label>
            <div class="form-row">
                <label>J <input type="number" name="jugados" min="0" value="0"></label>
                <label>G <input type="number" name="ganados" min="0" value="0"></label>
                <label>E <input type="number" name="empatados" min="0" value="0"></label>
                <label>P <input type="number" name="perdidos" min="0" value="0"></label>
            </div>
            <div class="form-row">
                <label>+/- <input type="number" name="diferencia_gol" value="0"></label>
                <label>PTS <input type="number" name="puntos" min="0" value="0"></label>
            </div>
            <button class="btn" type="submit">Guardar equipo</button>
        </form>
    </section>

    <section class="panel">
        <div class="section-title">Cargar goleador</div>
        <form class="form compact-form" method="post" action="<?= e(agregar_usuario('administrar_torneo.php?torneo=' . (int) $torneoId, $usuario)) ?>">
            <input type="hidden" name="usuario" value="<?= (int) $usuario['id'] ?>">
            <input type="hidden" name="accion" value="goleador">
            <label>Jugador <input type="text" name="nombre" required></label>
            <label>Equipo
                <select name="equipo_id" required>
                    <option value="">Seleccionar equipo</option>
                    <?php foreach ($equipos as $equipo): ?>
                        <option value="<?= (int) $equipo['id'] ?>"><?= e($equipo['zona']) ?> - <?= e($equipo['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <div class="form-row">
                <label>Goles <input type="number" name="goles" min="0" value="0"></label>
                <label>Amarillas <input type="number" name="amarillas" min="0" value="0"></label>
                <label>Rojas <input type="number" name="rojas" min="0" value="0"></label>
            </div>
            <button class="btn" type="submit">Guardar goleador</button>
        </form>
    </section>

    <section class="panel">
        <div class="section-title">Cargar partido</div>
        <form class="form compact-form" method="post" action="<?= e(agregar_usuario('administrar_torneo.php?torneo=' . (int) $torneoId, $usuario)) ?>">
            <input type="hidden" name="usuario" value="<?= (int) $usuario['id'] ?>">
            <input type="hidden" name="accion" value="partido">
            <div class="form-row">
                <label>Fecha nro. <input type="number" name="fecha_numero" min="1" value="1" required></label>
                <label>Dia <input type="date" name="fecha_partido" required></label>
            </div>
            <label>Local
                <select name="equipo_local_id" required>
                    <option value="">Seleccionar equipo</option>
                    <?php foreach ($equipos as $equipo): ?>
                        <option value="<?= (int) $equipo['id'] ?>"><?= e($equipo['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label>Visitante
                <select name="equipo_visitante_id" required>
                    <option value="">Seleccionar equipo</option>
                    <?php foreach ($equipos as $equipo): ?>
                        <option value="<?= (int) $equipo['id'] ?>"><?= e($equipo['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <div class="form-row">
                <label>Goles local <input type="number" name="goles_local" min="0"></label>
                <label>Goles visitante <input type="number" name="goles_visitante" min="0"></label>
            </div>
            <button class="btn" type="submit">Guardar partido</button>
        </form>
    </section>

    <section class="panel">
        <div class="section-title">Resumen cargado</div>
        <div class="admin-summary">
            <p><strong>Organizador:</strong> <?= e($torneo['creador_nombre'] ?? $usuario['nombre']) ?></p>
            <p><strong>Contacto:</strong> <?= e($torneo['creador_email'] ?? $usuario['email']) ?></p>
            <p><strong>Equipos:</strong> <?= count($equipos) ?></p>
            <p><strong>Goleadores:</strong> <?= count($jugadores) ?></p>
            <p><strong>Partidos:</strong> <?= count($partidos) ?></p>
        </div>
    </section>
</main>
</body>
</html>
