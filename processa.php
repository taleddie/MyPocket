<?php

require_once __DIR__ . '/database/conexao.php';

session_start();

$tipo = $_POST['tipo'] ?? '';
$valor = (float) ($_POST['valor'] ?? 0);
$data = $_POST['data'] ?? '';
$descricao = $_POST['descricao'] ?? '';

if (!in_array($tipo, ['receita', 'despesa'])) {
    $_SESSION['erro'] = 'Tipo inválido.';
    header('Location: index.php');
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO transacoes (tipo, data, valor, descricao, criado_em) VALUES (:tipo, :data, :valor, :descricao, NOW())");
    $stmt->execute(['tipo' => $tipo, 'data' => $data, 'valor' => $valor, 'descricao' => $descricao]);
    $_SESSION['sucesso'] = 'Transação cadastrada com sucesso.';
} catch (Exception $e) {
    $_SESSION['erro'] = 'Erro ao salvar transação: ' . $e->getMessage();
}

header('Location: index.php');
exit;

?>
