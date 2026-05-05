<?php
    // Formata um valor para o reais
    function formatarMoeda($valor) {
        return "R$ " . number_format($valor, 2, ',', '.');
    }

    // Calcula o saldo: soma receitas e diminui despesas
    function calcularSaldo($transacoes) {
        $saldo = 0;
        foreach ($transacoes as $t) {
            if ($t['tipo'] === 'Receita') {
                $saldo += $t['valor'];
            } else {
                $saldo -= $t['valor'];
            }
        }
        return $saldo;
    }

    // Soma o total de receitas
    function totalReceitas($transacoes) {
        $total = 0;
        foreach ($transacoes as $t) {
            if ($t['tipo'] === 'Receita') {
                $total += $t['valor'];
            }
        }
        return $total;
    }

    // Soma o total de despesas
    function totalDespesas($transacoes) {
        $total = 0;
        foreach ($transacoes as $t) {
            if ($t['tipo'] === 'Despesa') {
                $total += $t['valor'];
            }
        }
        return $total;
    }

?>