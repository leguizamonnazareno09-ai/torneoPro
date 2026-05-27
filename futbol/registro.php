<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/helpers.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($nombre === '' || $email === '' || $telefono === '' || strlen($password) < 6) {
        $error = 'Completa todos los campos. La contrasena debe tener al menos 6 caracteres.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Ingresa un email valido.';
    } else {
        try {
            $stmt = $pdo->prepare('INSERT INTO usuarios (nombre, email, telefono, password_hash) VALUES (?, ?, ?, ?)');
            $stmt->execute([$nombre, $email, $telefono, password_hash($password, PASSWORD_DEFAULT)]);
            header('Location: index.php?usuario=' . (int) $pdo->lastInsertId());
            exit;
        } catch (PDOException $exception) {
            $error = 'Ese email ya esta registrado.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<main class="page">
    <section class="panel">
        <div class="section-title">Crear cuenta</div>
        <form class="form" method="post" action="registro.php">
            <img class="logo" src="img/logo.jpeg" alt="TorneoPro">
            <?php if ($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>
            <label>Nombre completo <input type="text" name="nombre" required></label>
            <label>Email <input type="email" name="email" required></label>
            <label>Telefono <input type="tel" name="telefono" required></label>
            <label>Contrasena <input type="password" name="password" minlength="6" required></label>
            <button class="btn" type="submit">Registrarse</button>
            <p class="muted">Ya tenes cuenta? <a href="login.php">Inicia sesion</a></p>
        </form>
    </section>
</main>
</body>
</html>
