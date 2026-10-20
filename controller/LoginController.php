<?php
session_start();
require_once dirname(__FILE__) . '/../model/Usuario.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $senha = isset($_POST['senha']) ? trim($_POST['senha']) : '';

    if (empty($email) || empty($senha)) {
        $erro = 'Preencha e-mail e senha.';
    } else {
        $usuario = Usuario::buscarPorEmail($email);
        if ($usuario && Usuario::verificarSenha($senha, $usuario['senha'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            header('Location: ../controller/MenuController.php');
            exit;
        } else {
            $erro = 'E-mail ou senha incorretos.';
        }
    }
}

require_once dirname(__FILE__) . '/../view/login.php';
?>
