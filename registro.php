<?php 
// registro.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registrarse - TorneoPro</title>

<style>
/* Estilos copiados de tu archivo original */
* { margin:0; padding:0; box-sizing:border-box; }

body {
    min-height: 100vh;
    font-family: Arial, sans-serif;
    background: linear-gradient(to right, #0d0d0d 50%, #2b2b2b 50%);
    color: white;
    display: flex;
    justify-content: center;
    align-items: center;
}

.container {
    width: 100%;
    max-width: 420px;
    padding: 30px 20px;
    text-align: center;
}

.logo {
    width: 140px;
    height: 140px;
    border-radius: 50%;
    object-fit: cover;
    border: 5px solid #0d5c7d;
    margin-bottom: 25px;
}

h1 { margin-bottom: 30px; font-size: 2em; }

.form-group {
    margin-bottom: 18px;
    text-align: left;
}

label {
    display: block;
    margin-bottom: 6px;
    font-size: 0.95em;
}

input {
    width: 100%;
    padding: 14px;
    border-radius: 10px;
    border: none;
    background: #1f1f1f;
    color: white;
    font-size: 16px;
}

input:focus {
    outline: 2px solid #0d5c7d;
}

.error {
    color: #ff6b6b;
    font-size: 0.85em;
    margin-top: 5px;
    display: none;
}

.btn {
    width: 100%;
    padding: 15px;
    margin: 25px 0 15px;
    background: #0d5c7d;
    color: white;
    border: none;
    border-radius: 30px;
    font-size: 18px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}

.btn:hover {
    background: #0a4a64;
    transform: scale(1.03);
}
</style>
</head>
<body>

<div class="container">
    <img src="img/logo.jpeg" alt="TorneoPro" class="logo">
    <h1>Crear Cuenta</h1>

    <div class="form-group">
        <label>Nombre completo *</label>
        <input type="text" id="nombre" placeholder="Tu nombre">
        <div class="error" id="error-nombre">El nombre es obligatorio</div>
    </div>

    <div class="form-group">
        <label>Email *</label>
        <input type="email" id="email" placeholder="ejemplo@correo.com">
        <div class="error" id="error-email">Ingresa un email válido</div>
    </div>

    <div class="form-group">
        <label>Teléfono *</label>
        <input type="tel" id="telefono" placeholder="+54 11 1234-5678">
        <div class="error" id="error-telefono">El teléfono es obligatorio</div>
    </div>

    <div class="form-group">
        <label>Contraseña *</label>
        <input type="password" id="password" placeholder="••••••••">
        <div class="error" id="error-password">La contraseña es obligatoria (mínimo 6 caracteres)</div>
    </div>

    <button class="btn" onclick="registrarse()">Registrarse</button>

    <p>¿Ya tienes cuenta? <a href="login.php" class="login-link">Inicia sesión</a></p>
</div>

<script>
function registrarse() {
    document.querySelectorAll('.error').forEach(e => e.style.display = 'none');

    const nombre = document.getElementById('nombre').value.trim();
    const email = document.getElementById('email').value.trim();
    const telefono = document.getElementById('telefono').value.trim();
    const password = document.getElementById('password').value.trim();

    let valido = true;

    if (nombre === "") { document.getElementById('error-nombre').style.display = 'block'; valido = false; }
    if (email === "" || !email.includes("@")) { document.getElementById('error-email').style.display = 'block'; valido = false; }
    if (telefono === "") { document.getElementById('error-telefono').style.display = 'block'; valido = false; }
    if (password === "" || password.length < 6) { document.getElementById('error-password').style.display = 'block'; valido = false; }

    if (!valido) return;

    alert("¡Registro exitoso! Redirigiendo...");
    setTimeout(() => window.location.href = "zonas.php", 800);
}
</script>

</body>
</html>