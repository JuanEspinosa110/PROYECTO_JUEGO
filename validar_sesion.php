<?php
session_start();

// Verificar si hay una sesión activa
if (!isset($_SESSION['id_user']) && !isset($_SESSION['documento'])) {
    // Si no hay sesión, redirigir al login
    header("Location: ../../login.php?error=" . urlencode("Debes iniciar sesión primero"));
    exit();
}

// Si hay sesión, guarda el ID del usuario en una variable global
$id_user = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : $_SESSION['documento'];
?>
