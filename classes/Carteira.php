<?php

declare(strict_types=1);

require_once 'Receita.php';
require_once 'Despesa.php';

class Carteira {
    private $saldo;
    private $transacoes;

    public function __construct() {
        $this->saldo = 0.0;
        $this->transacoes = [];
    }

    public function getSaldo() {
        return $this->saldo;
    }

    public function getTransacoes() {
        return $this->transacoes;
    }

    public function adicionarReceita(Receita $receita) {
        $this->saldo += $receita->getValor();
        $this->transacoes[] = $receita;
    }

    public function adicionarDespesa(Despesa $despesa) {
        if ($despesa->getValor() > $this->saldo){
            throw new Exception("Saldo insuficiente.");
        } else {
            $this->saldo -= $despesa->getValor();
            $this->transacoes[] = $despesa;
        }
    }
}