<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/auth.php';

$error = '';
$next = $_GET['next'] ?? $_POST['next'] ?? 'index.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare('SELECT id, nombre, email, password_hash FROM usuarios WHERE email = ?');
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();

    if ($usuario && password_verify($password, $usuario['password_hash'])) {
        header('Location: ' . agregar_usuario($next, $usuario));
        exit;
    }

    $error = 'Email o contrasena incorrectos.';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<main class="page">
    <section class="panel">
        <div class="section-title">Iniciar sesion</div>
        <form class="form" method="post" action="login.php">
            <input type="hidden" name="next" value="<?= e($next) ?>">
            <img class="logo" src="img/logo.jpeg" alt="TorneoPro">
            <?php if ($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>
            <label>Email <input type="email" name="email" required></label>
            <label>Contrasena <input type="password" name="password" required></label>
            <button class="btn" type="submit">Ingresar</button>
            <p class="muted">No tenes cuenta? <a href="registro.php">Registrate</a></p>
        </form>
    </section>
</main>
</body>
</html>
