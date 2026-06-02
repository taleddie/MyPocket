<?php

class Receita extends Transacao {
    public function __construct($id, $data, $valor, $descricao) {
        parent::__construct($id, $data, $valor, $descricao);
    }

    public function getTipo() {
        return "Entrada";
    }
}
