<?php
    // Se não tem ninguém logado, manda de volta para o login
    if (!isset($_SESSION['usuario_logado'])) {
        header("Location: login.php");
        exit;
    }
?>
