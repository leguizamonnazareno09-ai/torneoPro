<?php
declare(strict_types=1);

function selected_torneo_id(): int
{
    return max(1, (int) ($_GET['torneo'] ?? $_POST['torneo'] ?? 1));
}

function load_torneo(PDO $pdo, int $torneoId): array
{
    $stmt = $pdo->prepare(
        'SELECT torneos.*, usuarios.nombre AS creador_nombre, usuarios.email AS creador_email, usuarios.telefono AS creador_telefono
         FROM torneos
         LEFT JOIN usuarios ON usuarios.id = torneos.creador_id
         WHERE torneos.id = ? AND torneos.activo = 1'
    );
    $stmt->execute([$torneoId]);
    $torneo = $stmt->fetch();

    if (!$torneo) {
        http_response_code(404);
        exit('Torneo no encontrado.');
    }

    return $torneo;
}

function require_torneo_owner(array $torneo, array $usuario): void
{
    if ((int) ($torneo['creador_id'] ?? 0) !== (int) $usuario['id']) {
        http_response_code(403);
        exit('No tenes permiso para administrar este torneo.');
    }
}
