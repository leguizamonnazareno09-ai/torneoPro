<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/auth.php';

$currentPage = 'inicio';
$search = trim($_GET['buscar'] ?? '');
$usuario = current_user($pdo);

$query = $pdo->prepare(
    'SELECT torneos.id, torneos.nombre, torneos.modalidad, torneos.temporada, torneos.barrio, torneos.descripcion, torneos.creador_id, usuarios.nombre AS creador
     FROM torneos
     LEFT JOIN usuarios ON usuarios.id = torneos.creador_id
     WHERE torneos.activo = 1
       AND (:search = "" OR torneos.nombre LIKE :nombreSearch OR torneos.modalidad LIKE :modalidadSearch OR torneos.barrio LIKE :barrioSearch)
     ORDER BY torneos.id DESC'
);
$query->execute([
    'search' => $search,
    'nombreSearch' => '%' . $search . '%',
    'modalidadSearch' => '%' . $search . '%',
    'barrioSearch' => '%' . $search . '%',
]);
$torneos = $query->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TorneoPro</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<header class="topbar">
    <a class="brand" href="index.php">
        <img src="img/logo.jpeg" alt="Torneos de Barrio">
        <span><strong>Torneos de Barrio</strong><span>Comunidad futbolera local</span></span>
    </a>
    <div class="actions">
        <?php if ($usuario): ?>
            <span class="session-name">Hola, <?= e($usuario['nombre']) ?></span>
            <a class="btn secondary" href="logout.php">Salir</a>
        <?php else: ?>
            <a class="btn secondary" href="login.php">Iniciar sesion</a>
            <a class="btn" href="registro.php">Registrarse</a>
        <?php endif; ?>
    </div>
</header>

<main class="home-screen">
    <section class="home-search">
        <img class="home-logo" src="img/logo.jpeg" alt="Torneos de Barrio">
        <h1>Torneos de Barrio</h1>
        <p>Busca torneos locales, segui a los equipos del barrio y suma tu campeonato a la comunidad.</p>

        <form class="search-box" method="get" action="index.php">
            <span>Buscar</span>
            <input type="search" name="buscar" value="<?= e($search) ?>" placeholder="Nombre, barrio o modalidad">
            <button class="btn" type="submit">Buscar</button>
        </form>

        <?php if ($usuario): ?>
            <div class="creator-callout">
                <strong>Tenes un torneo en tu barrio?</strong>
                <a class="btn" href="<?= e(agregar_usuario('crear_torneo.php', $usuario)) ?>">Crear torneo</a>
            </div>
        <?php endif; ?>

        <div class="result-list">
            <?php foreach ($torneos as $torneo): ?>
                <?php
                $esCreador = $usuario && (int) ($torneo['creador_id'] ?? 0) === (int) $usuario['id'];
                $torneoUrl = $esCreador
                    ? 'administrar_torneo.php?torneo=' . (int) $torneo['id']
                    : 'zonas.php?torneo=' . (int) $torneo['id'];
                ?>
                <a class="result" href="<?= $usuario ? e(agregar_usuario($torneoUrl, $usuario)) : 'login.php?next=' . urlencode($torneoUrl) ?>">
                    <strong><?= e($torneo['nombre']) ?></strong><br>
                    <span class="muted"><?= e($torneo['barrio']) ?> | <?= e($torneo['modalidad']) ?> | <?= e($torneo['temporada']) ?></span>
                    <?php if ($torneo['descripcion']): ?>
                        <small><?= e($torneo['descripcion']) ?></small>
                    <?php endif; ?>
                    <?php if ($torneo['creador']): ?>
                        <em>Creado por <?= e($torneo['creador']) ?></em>
                    <?php endif; ?>
                    <?php if ($esCreador): ?>
                        <em>Administrar este torneo</em>
                    <?php endif; ?>
                </a>
            <?php endforeach; ?>

            <?php if (!$torneos): ?>
                <div class="alert">No se encontraron torneos.</div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php if ($usuario) require __DIR__ . '/includes/nav.php'; ?>
</body>
</html>
