<?php
session_start();
if (!isset($_SESSION['usuario_id'])) { header('Location: ../controller/LoginController.php'); exit; }
require_once dirname(__FILE__) . '/../model/Cliente.php';

$acao = isset($_GET['acao']) ? $_GET['acao'] : 'listar';
$sucesso = '';
$erro = '';

// SALVAR
if ($acao === 'salvar') {
    $nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
    $telefone = isset($_POST['telefone']) ? trim($_POST['telefone']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';

    if (empty($nome)) {
        $erro = 'O nome é obrigatório.'; $acao = 'cadastrar';
    } else {
        if (Cliente::salvar($nome, $telefone, $email)) { $sucesso = 'Cliente cadastrado!'; $acao = 'listar'; }
        else { $erro = 'Erro ao salvar.'; $acao = 'cadastrar'; }
    }
}

// ATUALIZAR
if ($acao === 'atualizar') {
    $id = (int) $_POST['id'];
    $nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
    $telefone = isset($_POST['telefone']) ? trim($_POST['telefone']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';

    if (empty($nome)) {
        $erro = 'O nome é obrigatório.'; $acao = 'editar';
    } else {
        if (Cliente::atualizar($id, $nome, $telefone, $email)) { $sucesso = 'Cliente atualizado!'; $acao = 'listar'; }
        else { $erro = 'Erro ao atualizar.'; $acao = 'editar'; }
    }
}

// EXCLUIR
if ($acao === 'excluir') {
    $id = (int) $_GET['id'];
    Cliente::excluir($id);
    $sucesso = 'Cliente excluído.';
    $acao = 'listar';
}

$clientes = array();
$cliente = null;

if ($acao === 'listar') {
    $clientes = Cliente::listarTodos();
}

if ($acao === 'editar') {
    $id = isset($_GET['id']) ? (int)$_GET['id'] : (isset($_POST['id']) ? (int)$_POST['id'] : 0);
    $cliente = Cliente::buscarPorId($id);
    if (!$cliente) { $acao = 'listar'; $clientes = Cliente::listarTodos(); }
}

require_once dirname(__FILE__) . '/../view/clientes.php';
?>
