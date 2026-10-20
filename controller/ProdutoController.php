<?php
session_start();
if (!isset($_SESSION['usuario_id'])) { header('Location: ../controller/LoginController.php'); exit; }
require_once dirname(__FILE__) . '/../model/Produto.php';
require_once dirname(__FILE__) . '/../model/Categoria.php';

$acao = isset($_GET['acao']) ? $_GET['acao'] : 'listar';
$sucesso = '';
$erro = '';

// SALVAR
if ($acao === 'salvar') {
    $nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
    $categoria_id = isset($_POST['categoria_id']) ? (int)$_POST['categoria_id'] : null;
    $preco = isset($_POST['preco']) ? (float)$_POST['preco'] : 0;
    $estoque = isset($_POST['estoque']) ? (int)$_POST['estoque'] : 0;

    if (empty($nome)) {
        $erro = 'O nome é obrigatório.'; $acao = 'cadastrar';
    } else {
        if (Produto::salvar($nome, $categoria_id, $preco, $estoque)) { $sucesso = 'Produto cadastrado!'; $acao = 'listar'; }
        else { $erro = 'Erro ao salvar.'; $acao = 'cadastrar'; }
    }
}

// ATUALIZAR
if ($acao === 'atualizar') {
    $id = (int) $_POST['id'];
    $nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
    $categoria_id = isset($_POST['categoria_id']) ? (int)$_POST['categoria_id'] : null;
    $preco = isset($_POST['preco']) ? (float)$_POST['preco'] : 0;
    $estoque = isset($_POST['estoque']) ? (int)$_POST['estoque'] : 0;

    if (empty($nome)) {
        $erro = 'O nome é obrigatório.'; $acao = 'editar';
    } else {
        if (Produto::atualizar($id, $nome, $categoria_id, $preco, $estoque)) { $sucesso = 'Produto atualizado!'; $acao = 'listar'; }
        else { $erro = 'Erro ao atualizar.'; $acao = 'editar'; }
    }
}

// EXCLUIR
if ($acao === 'excluir') {
    $id = (int) $_GET['id'];
    Produto::excluir($id);
    $sucesso = 'Produto excluído.';
    $acao = 'listar';
}

// Carregar dados conforme ação
$produtos = array();
$produto = null;
$categorias = Categoria::listarTodas();

if ($acao === 'listar') {
    $produtos = Produto::listarTodos();
}

if ($acao === 'editar') {
    $id = isset($_GET['id']) ? (int)$_GET['id'] : (isset($_POST['id']) ? (int)$_POST['id'] : 0);
    $produto = Produto::buscarPorId($id);
    if (!$produto) { $acao = 'listar'; $produtos = Produto::listarTodos(); }
}

require_once dirname(__FILE__) . '/../view/produtos.php';
?>
