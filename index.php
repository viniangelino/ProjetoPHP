<?php
    session_start();
    require_once "verifica.php";
    require_once "funcoes.php";

    // Cria o array de transações
    if (!isset($_SESSION['transacoes'])) {
        $_SESSION['transacoes'] = [];
    }

    $mensagem_erro = '';

    // Botão de zerar: limpa todas as transações
    if (isset($_POST['zerar'])) {
        $_SESSION['transacoes'] = [];
        header("Location: index.php");
        exit;
    }

    // Cadastra uma nova transação
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['descricao'])) {
        $data_digitada = $_POST['data'] ?? '';
        $hoje = date('Y-m-d');

        // Bloqueia datas futuras
        if ($data_digitada > $hoje) {
            $mensagem_erro = "Não é permitido cadastrar transações com data futura!";
        } else {
            $nova_transacao = [
                "descricao" => $_POST['descricao'] ?? '',
                "valor"     => floatval($_POST['valor'] ?? 0),
                "tipo"      => $_POST['tipo'] ?? '',
                "data"      => $data_digitada
            ];
            $_SESSION['transacoes'][] = $nova_transacao;
        }
    }

    // Calcula os valores usando as funções
    $total_receitas   = totalReceitas($_SESSION['transacoes']);
    $total_despesas   = totalDespesas($_SESSION['transacoes']);
    $saldo_disponivel = calcularSaldo($_SESSION['transacoes']);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>MyWallet - Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <h1>Olá, <?= $_SESSION['usuario_logado'] ?>!</h1>
        <a href="sair.php">Sair</a> | <a href="historico.php">Ver Histórico Completo</a>
        <hr>

        <?php if ($mensagem_erro): ?>
            <p class="erro"><strong><?= $mensagem_erro ?></strong></p>
        <?php endif; ?>

        <h3>Resumo Financeiro</h3>
        <p>Total Receitas: <?= formatarMoeda($total_receitas) ?></p>
        <p>Total Despesas: <?= formatarMoeda($total_despesas) ?></p>
        <h2>Saldo Disponível: <?= formatarMoeda($saldo_disponivel) ?></h2>

        <hr>

        <h3>Nova Transação</h3>
        <form method="POST" action="index.php">
            <label>Descrição:</label><br>
            <input type="text" name="descricao" required><br><br>

            <label>Valor (R$):</label><br>
            <input type="number" step="0.01" name="valor" required><br><br>

            <label>Data:</label><br>
            <input type="date" name="data" value="<?= date('Y-m-d') ?>" max="<?= date('Y-m-d') ?>" required><br><br>

            <label>Tipo:</label><br>
            <select name="tipo">
                <option value="Receita">Receita</option>
                <option value="Despesa">Despesa</option>
            </select><br><br>

            <button type="submit">Adicionar Transação</button>
        </form>

        <hr>

        <h3>Ações</h3>
        <form method="POST" action="index.php" onsubmit="return confirm('Tem certeza que deseja zerar todas as transações?');">
            <button type="submit" name="zerar">Zerar Mês</button>
        </form>
    </main>

    <footer>
        Criado por Vinicius Vicente Angelino &amp; Luís de Paula Fogaça - PHP Ecoville
    </footer>
</body>
</html>
