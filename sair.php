<?php
    session_start();

    // Apaga todos os dados da sessão
    session_destroy();

    // Volta para o login
    header("Location: login.php");
    exit;
?>
