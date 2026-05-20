<?php 
// login.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Iniciar Sesión - TorneoPro</title>

<style>
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

label { display: block; margin-bottom: 6px; font-size: 0.95em; }

input {
    width: 100%;
    padding: 14px;
    border-radius: 10px;
    border: none;
    background: #1f1f1f;
    color: white;
    font-size: 16px;
}

input:focus { outline: 2px solid #0d5c7d; }

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

.btn:hover { background: #0a4a64; transform: scale(1.03); }
</style>
</head>
<body>

<div class="container">
    <img src="img/logo.jpeg" alt="TorneoPro" class="logo">
    <h1>Iniciar Sesión</h1>

    <div class="form-group">
        <label>Email o Usuario *</label>
        <input type="text" id="login-user" placeholder="ejemplo@correo.com">
        <div class="error" id="error-user">Este campo es obligatorio</div>
    </div>

    <div class="form-group">
        <label>Contraseña *</label>
        <input type="password" id="login-password" placeholder="••••••••">
        <div class="error" id="error-login-password">La contraseña es obligatoria</div>
    </div>

    <button class="btn" onclick="iniciarSesion()">Ingresar</button>

    <p>¿No tienes cuenta? <a href="registro.php" class="signup-link">Regístrate</a></p>
</div>

<script>
function iniciarSesion() {
    document.querySelectorAll('.error').forEach(e => e.style.display = 'none');

    const user = document.getElementById('login-user').value.trim();
    const password = document.getElementById('login-password').value.trim();

    if (user === "" || password === "") {
        alert("Por favor completa todos los campos");
        return;
    }

    alert("¡Inicio de sesión exitoso!");
    setTimeout(() => window.location.href = "zonas.php", 800);
}
</script>

</body>
</html>