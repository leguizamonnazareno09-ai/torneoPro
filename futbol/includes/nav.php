<?php
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/auth.php';

$torneoParam = isset($torneoId) ? 'torneo=' . (int) $torneoId : '';
$usuarioParam = isset($usuario) ? usuario_param($usuario) : '';
$params = array_filter([$torneoParam, $usuarioParam]);
$query = $params ? '?' . implode('&', $params) : '';
$homeQuery = $usuarioParam ? '?' . $usuarioParam : '';
?>
<nav class="bottom-nav" aria-label="Navegacion principal">
    <a href="index.php<?= $homeQuery ?>" class="nav-item<?= active('inicio', $currentPage ?? '') ?>"><span>IN</span><strong>Inicio</strong></a>
    <a href="zonas.php<?= $query ?>" class="nav-item<?= active('zonas', $currentPage ?? '') ?>"><span>ZO</span><strong>Zonas</strong></a>
    <a href="goleadores.php<?= $query ?>" class="nav-item<?= active('goleadores', $currentPage ?? '') ?>"><span>GO</span><strong>Goles</strong></a>
    <a href="fixture.php<?= $query ?>" class="nav-item<?= active('fixture', $currentPage ?? '') ?>"><span>FI</span><strong>Fixture</strong></a>
    <a href="contacto.php<?= $query ?>" class="nav-item<?= active('contacto', $currentPage ?? '') ?>"><span>CO</span><strong>Contacto</strong></a>
</nav>
