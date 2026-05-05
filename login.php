<?php
    session_start();

    // Lista de usuários e senha
    $usuarios = [
        "admin"     => password_hash("123456", PASSWORD_DEFAULT),
        "professor" => password_hash("positivo", PASSWORD_DEFAULT)
    ];

    $mensagem_erro = '';

    // Se já logado, vai direto para o index
    if (isset($_SESSION['usuario_logado'])) {
        header("Location: index.php");
        exit;
    }


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $usuario_digitado = $_POST['usuario'] ?? '';
        $senha_digitada   = $_POST['senha'] ?? '';


        // Conferencia de senha
        if (isset($usuarios[$usuario_digitado]) && password_verify($senha_digitada, $usuarios[$usuario_digitado])) {
            $_SESSION['usuario_logado'] = $usuario_digitado;
            header("Location: index.php");
            exit;
        } else {
            $mensagem_erro = "Usuário ou senha incorretos!";
        }
    }
?>

<!-- INICIO DO HTML -->

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="tela-login">
        <h2>Tela de Login</h2>

        <?php if ($mensagem_erro): ?>
            <p class="erro"><?= $mensagem_erro ?></p>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <label>Usuário:</label><br>
            <input type="text" name="usuario" required><br><br>

            <label>Senha:</label><br>
            <input type="password" name="senha" required><br><br>

            <button type="submit">Entrar</button>
        </form>
    </main>

    <footer>
        Criado por Vinicius Vicente Angelino &amp; Luís de Paula Fogaça - PHP Ecoville
    </footer>
</body>
</html>