<?php
    session_start();
    require_once "verifica.php";
    require_once "funcoes.php";

    // Garante que o array existe
    if (!isset($_SESSION['transacoes'])) {
        $_SESSION['transacoes'] = [];
    }

    $transacoes = $_SESSION['transacoes'];
    $saldo      = calcularSaldo($transacoes);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Minha Carteira - Histórico</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <h1>Histórico de Transações</h1>
        <a href="index.php">Voltar ao Dashboard</a> | <a href="sair.php">Sair</a>
        <hr>

        <h3>Saldo Atual: <?= formatarMoeda($saldo) ?></h3>

        <?php if (count($transacoes) === 0): ?>
            <p>Nenhuma transação registrada ainda.</p>
        <?php else: ?>

            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Data</th>
                        <th>Descrição</th>
                        <th>Tipo</th>
                        <th>Valor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $contador = 1; ?>
                    <?php foreach ($transacoes as $t): ?>
                        <?php
                            // Converte a data do formato AAAA-MM-DD para DD/MM/AAAA
                            $data_formatada = '-';
                            if (!empty($t['data'])) {
                                $data_formatada = date('d/m/Y', strtotime($t['data']));
                            }
                        ?>
                        <tr>
                            <td><?= $contador ?></td>
                            <td><?= $data_formatada ?></td>
                            <td><?= $t['descricao'] ?></td>
                            <td><?= $t['tipo'] ?></td>
                            <td><?= formatarMoeda($t['valor']) ?></td>
                        </tr>
                        <?php $contador++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <p>Total de transações: <?= count($transacoes) ?></p>

        <?php endif; ?>
    </main>

    <footer>
        Criado por Vinicius Vicente Angelino &amp; Luís de Paula Fogaça - PHP Ecoville
    </footer>
</body>
</html>
