<?php
declare(strict_types=1);

function request_user_id(): int
{
    return max(0, (int) ($_GET['usuario'] ?? $_POST['usuario'] ?? 0));
}

function current_user(PDO $pdo): ?array
{
    $usuarioId = request_user_id();

    if ($usuarioId === 0) {
        return null;
    }

    $stmt = $pdo->prepare('SELECT id, nombre, email, telefono FROM usuarios WHERE id = ?');
    $stmt->execute([$usuarioId]);
    $usuario = $stmt->fetch();

    return $usuario ?: null;
}

function require_login(PDO $pdo): array
{
    $usuario = current_user($pdo);

    if (!$usuario) {
        $next = $_SERVER['REQUEST_URI'] ?? 'index.php';
        header('Location: login.php?next=' . urlencode($next));
        exit;
    }

    return $usuario;
}

function usuario_param(?array $usuario): string
{
    return $usuario ? 'usuario=' . (int) $usuario['id'] : '';
}

function agregar_usuario(string $url, ?array $usuario): string
{
    if (!$usuario) {
        return $url;
    }

    $separador = str_contains($url, '?') ? '&' : '?';
    return $url . $separador . usuario_param($usuario);
}
