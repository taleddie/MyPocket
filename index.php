<?php

require_once __DIR__ . '/classes/Carteira.php';

session_start();

if (!isset($_SESSION['carteira'])) {
    $_SESSION['carteira'] = new Carteira();
}

$carteira = $_SESSION['carteira'];
$saldo = $carteira->getSaldo();
$transacoes = $carteira->getTransacoes();

// Captura e limpa mensagens de feedback
$erro = $_SESSION['erro'] ?? null;
unset($_SESSION['erro']);

$hoje = date('Y-m-d');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Document</title>

    <style>
        .activeGreen {
            box-shadow: 0 0 0 3px #146c43 !important;
        }

        .activeRed {
            box-shadow: 0 0 0 3px #b02a37 !important;
        }

        .bg {
            background-image: url(../img/bank.png);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            width: 100%;
        }

        #card-saldo,
        #card-form,
        #card-extrato {
            background: #ffffff9a;
            border-radius: 25px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.71);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.84);
        }

        #header {
            width: 100%;
            height: 100px;
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
        }

        @media (min-width: 768px) {
            #card-extrato { 
                max-height: 630px;
                overflow-y: auto;
            }
        }

    </style>

</head>

<body>

    <!-- background div -->
    <div class="bg">

    <header class="d-flex justify-content-center align-items-center" id="header">
        <h1 class="">MyPocket</h1>
    </header>

    <div class="container py-5">
        <div class="gx-5 row justify-content-center">
            <div class="col justify-content-center">

                <!-- saldo -->
                <div class="p-3 mb-2 text-dark" id="card-saldo">
                    <h2 class="m-3 text-center fw-bold">Saldo</h2>
                    <div class="saldo-valor">
                        <p class="text-center fs-4">R$ <?= number_format($saldo, 2, ',', '.') ?></p>
                    </div>
                </div>

                <!-- alertas -->
                <?php if ($erro): ?>
                    <div class="alert alert-danger rounded-4 py-2 px-3" role="alert">
                        <?= htmlspecialchars($erro) ?>
                    </div>
                <?php endif; ?>

                <?php if ($sucesso): ?>
                    <div class="alert alert-success rounded-4 py-2 px-3" role="alert">
                        <?= htmlspecialchars($sucesso) ?>
                    </div>
                <?php endif; ?>

                <!--form-->
                <div class="p-3 mb-2 text-dark" id="card-form">
                    <form action="processa.php" method="POST">
                        <h2 class="m-3 text-center fw-bold">Nova transação</h2>

                        <!-- botoes receita ou despesa -->
                        <div class="d-flex justify-content-center gap-3 ">
                            <input type="hidden" id="tipo" name="tipo">
                            <button type="button" id="btnReceita" class="btn btn-success rounded-5">Receita</button>
                            <button type="button" id="btnDespesa" class="btn btn-danger rounded-5">Despesa</button>
                        </div>

                        <!-- valor -->
                        <div class="mb-3 mt-3 mx-5">
                            <label for="formGroupExampleInput">Valor</label>
                            <input type="number" name="valor" class="rounded-5 form-control shadow"
                                id="formGroupExampleInput" min="0.01" step="0.01" placeholder="0,00" required>
                        </div>

                        <!-- data -->
                        <div class="mb-3 mt-3 mx-5">
                            <label for="data" class="form-label">Data</label>
                            <input type="date" class="rounded-5 form-control shadow" max="<?= $hoje ?>" name="data" required>
                        </div>

                        <!-- descrição -->
                        <div class="mb-3 mt-3 mx-5">
                            <label for="formGroupExampleInput">Descrição</label>
                            <input type="text" name="descricao" class="rounded-5 form-control shadow"
                                id="formGroupExampleInput" placeholder="Conta de luz, aluguel, etc..." required>
                        </div>

                        <!-- botao cadastrar -->
                        <div class="d-flex justify-content-center gap-3 ">
                            <button type="submit" class="btn btn-dark rounded-5 mb-3 mt-3">
                                Cadastrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- extrato --->
            <div class="col-md-5 mb-2">
                <div class="p-4" id="card-extrato">
                <?php if (empty($transacoes)): ?>
                <p class="text-muted text-center mt-5">Nenhuma transação cadastrada ainda.</p>
                <?php else: ?>
                <div class="list-group list-group-flush">

                    <!-- mais recentes primeiros -->
                    <?php
                    $ordem = array_reverse($transacoes);

                    // box de cada transacao feita
                    foreach ($ordem as $info): ?>
                    <div class="d-flex justify-content-between align-items-center border rounded p-3 mb-2">

                        <div>
                            <span class="badge <?= $info->getTipo() === 'Entrada' ? 'bg-success' : 'bg-danger' ?>">
                                <?= $info->getTipo() ?>
                            </span>

                            <div class="mt-1">
                                <?= $info->getDescricao() ?>
                            </div>
                        </div>

                        <div class="text-end">
                            <div class="fw-bold">
                                R$ <?= number_format($info->getValor(), 2, ',', '.') ?>
                            </div>

                            <small class="text-muted">
                                <?= date('d/m/Y', strtotime($info->getData())) ?> <!-- altera o formato da data -->
                            </small>
                        </div>

                    </div>
                    <?php endforeach ?>
                    <?php endif ?>
                </div>
            </div>
            
            </div>
        </div>

    </div>
    
    

        <script>
            const btnReceita = document.getElementById("btnReceita");
            const btnDespesa = document.getElementById("btnDespesa");
            const tipo = document.getElementById("tipo");

            document.querySelector("form").addEventListener("submit", (e) => {
                if (!tipo.value) {
                    e.preventDefault();
                    alert("Selecione Receita ou Despesa.");
                }
            });

            btnReceita.addEventListener("click", () => {
                tipo.value = "receita";

                btnReceita.classList.add("activeGreen");
                btnDespesa.classList.remove("activeRed");
            });

            btnDespesa.addEventListener("click", () => {
                tipo.value = "despesa";

                btnDespesa.classList.add("activeRed");
                btnReceita.classList.remove("activeGreen");
            });

        </script>

</body>

</html>
