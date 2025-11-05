<?php
session_start();
require_once("DB/conection.php");
$db = new Database();
$con = $db->conectar();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario']);
    $clave = $_POST['clave'];

    // Verificar usuario
    $query = $con->prepare("SELECT * FROM usuario WHERE username = :usuario");
    $query->bindParam(':usuario', $usuario);
    $query->execute();
    $data = $query->fetch(PDO::FETCH_ASSOC);

    if ($data && password_verify($clave, $data['contrasena'])) {
        // Validar si está bloqueado
        if ($data['id_estado'] == 2) {
            echo "<script>alert('Tu cuenta está bloqueada. Espera la activación del administrador.'); window.location='index.php';</script>";
            exit();
        }

        // Guardar sesión
        $_SESSION['id_user'] = $data['id_user'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['id_tip_user'] = $data['id_tip_user']; // admin o jugador

        // Redirigir según tipo de usuario
        if ($data['id_tip_user'] == 1) {
          header("Location: modulo/ADMIN/index.php");
        } elseif ($data['id_tip_user'] == 2) {
          header("Location: modulo/USERS/index.php");
        } else {
            echo "<script>alert('Tipo de usuario desconocido.'); window.location='index.php';</script>";
        }
        exit();
    } else {
        echo "<script>alert('Usuario o contraseña incorrectos.'); window.location='index.php';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Inicio Sesión | Free Fire</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">

  <style>
    body {
      margin: 0;
      padding: 0;
      overflow: hidden;
    }

    /* Fondo de YouTube */
    .video-background {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      overflow: hidden;
      z-index: -1;
    }

    .video-background iframe {
      width: 100%;
      height: 100%;
      pointer-events: none;
    }

    /* Mantener estilo original del login */
    .login-card {
      background: rgba(0, 0, 0, 0.85);
      border-radius: 15px;
      box-shadow: 0 0 25px rgba(255, 193, 7, 0.5);
      color: #ffc107;
      max-width: 400px;
      width: 100%;
    }

    .login-card .form-control {
      border: 1px solid #ffc107;
      background: transparent;
      color: #fff;
    }

    .login-card .form-control::placeholder {
      color: #ffc107;
      opacity: 0.8;
    }

    .login-card .btn-warning {
      background-color: #ffc107;
      border: none;
      color: black;
      font-weight: bold;
    }

    .login-card a {
      color: #ffc107;
      text-decoration: none;
      font-weight: 500;
    }

    .login-card a:hover {
      text-decoration: underline;
    }

    .login-card img {
      filter: drop-shadow(0 0 5px #ffc107);
    }
  </style>
</head>

<body class="d-flex align-items-center justify-content-center vh-100">

  <!-- 🔹 Video de fondo YouTube -->
  <div class="video-background">
    <iframe 
      src="https://www.youtube.com/embed/cra6_jPNMt0?autoplay=1&mute=1&controls=0&loop=1&playlist=cra6_jPNMt0&modestbranding=1&showinfo=0"
      frameborder="0"
      allow="autoplay; fullscreen"
      allowfullscreen>
    </iframe>
  </div>

  <!-- 🔸 Tarjeta de login (mismo estilo que en tu imagen) -->
  <div class="login-card p-4 text-center">
    <div class="mb-3">
			<img src="IMG/logo.png" alt="Logo" width="100">
      <h1 class="h4 mt-2 text-warning fw-bold">Inicio de Sesión</h1>
    </div>

    <form method="POST" autocomplete="off">
      <div class="mb-3 text-start">
        <label for="usuario" class="form-label text-warning">Usuario</label>
        <input type="text" class="form-control" name="usuario" id="usuario" placeholder="Digite Usuario" required>
      </div>

      <div class="mb-3 text-start">
        <label for="password" class="form-label text-warning">Contraseña</label>
        <input type="password" class="form-control" name="clave" id="password" placeholder="Ingrese Contraseña" required>
      </div>

      <div class="d-grid mb-3">
        <button type="submit" class="btn btn-warning w-100">Validar</button>
      </div>
    </form>

    <div class="text-center">
      <a href="recuperar_contra.php">Recuperar Contraseña</a>    
      <a href="registrarme.php" class="ms-2">Registrarme?</a>
    </div>
  </div>
</body>
</html>
