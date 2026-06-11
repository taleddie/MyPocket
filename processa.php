<?php

require_once 'classes/Carteira.php';

session_start();

if (!isset($_SESSION['carteira'])) {
    $_SESSION['carteira'] = new Carteira();
}

$carteira = $_SESSION['carteira'];

$tipo = $_POST['tipo'];
$valor = (float) $_POST['valor'];
$data = $_POST['data'];
$descricao = $_POST['descricao'];
$id = (int) count($carteira->getTransacoes()) + 1;

try {
    if ($tipo === 'receita') {
        $transacao = new Receita($id, $data, $valor, $descricao);
        $carteira->adicionarReceita($transacao);
    } else {
        $transacao = new Despesa($id, $data, $valor, $descricao);
        $carteira->adicionarDespesa($transacao);
    }
} catch (Exception $e) {
    $_SESSION['erro'] = $e->getMessage();
}

$_SESSION['carteira'] = $carteira;
header("Location: index.php");
exit;

?>
