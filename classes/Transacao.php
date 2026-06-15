<?php

declare(strict_types=1);

abstract class Transacao {
    protected $data;
    protected $valor;
    protected $descricao;

    public function __construct($data, $valor, $descricao) {
        $this->data = $data;
        $this->valor = $valor;
        $this->descricao = $descricao;
    }

    public function getData () {
        return $this->data;
    }

    public function getValor () {
        return $this->valor;
    }

    public function getDescricao () {
        return $this->descricao;
    }

    abstract public function getTipo();

}
