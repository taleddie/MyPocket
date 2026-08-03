# MyPocket 💰

O **MyPocket** é um sistema financeiro desenvolvido em **PHP** utilizando os princípios da **Programação Orientada a Objetos (POO)**. O projeto simula o back-end de uma fintech de organização financeira pessoal, permitindo o gerenciamento de receitas, despesas, saldo e histórico de transações.

O sistema foi desenvolvido com foco na aplicação de conceitos fundamentais de orientação a objetos, como **encapsulamento, herança, abstração, polimorfismo e tratamento de exceções**, garantindo maior segurança e organização dos dados financeiros.

## Funcionalidades

- Cadastro de receitas e despesas;
- Atualização automática do saldo da carteira;
- Impedimento de saldo negativo através de exceções;
- Histórico completo de transações (extrato);
- Identificação de entradas e saídas;
- Interface responsiva desenvolvida com Bootstrap.

## Conceitos aplicados

- Programação Orientada a Objetos (POO);
- Classes abstratas;
- Herança;
- Encapsulamento;
- Polimorfismo;
- Métodos mágicos (`__construct`);
- Tratamento de exceções (`try/catch`);
- Tipagem estrita (`declare(strict_types=1)`).

## Estrutura do projeto

```text
mypocket/
├── classes/
│   ├── Transacao.php
│   ├── Receita.php
│   ├── Despesa.php
│   └── Carteira.php
├── processa.php
└── index.php
```

## Tecnologias utilizadas

- PHP 8.1+
- HTML5
- Bootstrap 5
- Git e GitHub

---

Projeto desenvolvido para a disciplina de **Programação Web II**, com o objetivo de aplicar boas práticas de desenvolvimento e modelagem de sistemas utilizando PHP.
