<?php 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = strip_tags(trim($_POST["nombre"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $telefono = strip_tags(trim($_POST["telefono"]));
    $mensaje = strip_tags(trim($_POST["mensaje"]));

    if (!empty($nombre) && !empty($email) && !empty($mensaje) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        
        $to = "torneoapertura2026@gmail.com";
        $subject = "Nuevo mensaje de $nombre - Torneo Apertura 2026";
        
        $body = "Nombre: $nombre\n";
        $body .= "Email: $email\n";
        $body .= "Teléfono: $telefono\n\n";
        $body .= "Mensaje:\n$mensaje";
        
        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/plain; charset=utf-8";

        if (mail($to, $subject, $body, $headers)) {
            $status = "success";
        } else {
            $status = "error";
        }
    } else {
        $status = "incomplete";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contacto - Torneo Apertura 2026</title>
<link rel="stylesheet" href="estilos.css">
</head>
<body>

<div class="header">
    <div class="torneo">TORNEO APERTURA 2026 MASC F7</div>
</div>

<div class="zona">
    <div class="zona-titulo">📞 CONTACTO</div>
    <div class="contact-content">
      
    </div>
</div>

<div class="formulario">
    <h2 style="text-align:center; margin-bottom:20px; color:var(--accent);">Envíanos tu Mensaje</h2>
    
    <?php if(isset($status)): ?>
        <?php if($status == "success"): ?>
            <p style="color:green; text-align:center; font-weight:bold;">✅ Mensaje enviado correctamente!</p>
        <?php elseif($status == "error"): ?>
            <p style="color:red; text-align:center;">❌ Error al enviar el mensaje. Inténtalo más tarde.</p>
        <?php endif; ?>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="nombre" placeholder="Nombre completo" required>
        <input type="email" name="email" placeholder="Correo electrónico" required>
        <input type="tel" name="telefono" placeholder="Teléfono / WhatsApp">
        <textarea name="mensaje" placeholder="Escribe tu mensaje, consulta o sugerencia..." required></textarea>
        
        <button type="submit">Enviar Mensaje</button>
    </form>
</div>

<!-- Bottom Nav -->
<div class="bottom-nav">
    <a href="index.php" class="nav-item"><i>🏠</i><div>Inicio</div></a>
    <a href="zonas.php" class="nav-item"><i>📊</i><div>Zonas</div></a>
    <a href="goleadores.php" class="nav-item"><i>🥇</i><div>Goleadores</div></a>
    <a href="fixture.php" class="nav-item"><i>📅</i><div>Fixture</div></a>
    <a href="contacto.php" class="nav-item active"><i>📞</i><div>Contacto</div></a>
</div>

</body>
</html>
