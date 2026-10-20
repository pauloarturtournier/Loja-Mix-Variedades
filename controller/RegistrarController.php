<?php
session_start();
require_once dirname(__FILE__) . '/../model/Usuario.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome  = isset($_POST['nome']) ? trim($_POST['nome']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $senha = isset($_POST['senha']) ? trim($_POST['senha']) : '';
    $confirmarSenha = isset($_POST['confirmar_senha']) ? trim($_POST['confirmar_senha']) : '';

    if (empty($nome) || empty($email) || empty($senha)) {
        $erro = 'Preencha todos os campos.';
    } elseif ($senha !== $confirmarSenha) {
        $erro = 'As senhas não batem.';
    } elseif (Usuario::buscarPorEmail($email)) {
        $erro = 'Este e-mail já está cadastrado.';
    } else {
        if (Usuario::cadastrar($nome, $email, $senha)) {
            header('Location: ../controller/LoginController.php?cadastro=ok');
            exit;
        } else {
            $erro = 'Erro ao cadastrar. Tente novamente.';
        }
    }
}

require_once dirname(__FILE__) . '/../view/registrar.php';
?>
