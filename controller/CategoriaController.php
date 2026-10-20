<?php
session_start();
if (!isset($_SESSION['usuario_id'])) { header('Location: ../controller/LoginController.php'); exit; }
require_once dirname(__FILE__) . '/../model/Categoria.php';

$acao = isset($_GET['acao']) ? $_GET['acao'] : 'listar';
$sucesso = '';
$erro = '';

// SALVAR
if ($acao === 'salvar') {
    $nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
    if (empty($nome)) {
        $erro = 'O nome é obrigatório.'; $acao = 'cadastrar';
    } else {
        if (Categoria::salvar($nome)) { $sucesso = 'Categoria cadastrada!'; $acao = 'listar'; }
        else { $erro = 'Erro ao salvar.'; $acao = 'cadastrar'; }
    }
}

// ATUALIZAR
if ($acao === 'atualizar') {
    $id = (int) $_POST['id'];
    $nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
    if (empty($nome)) {
        $erro = 'O nome é obrigatório.'; $acao = 'editar';
    } else {
        if (Categoria::atualizar($id, $nome)) { $sucesso = 'Categoria atualizada!'; $acao = 'listar'; }
        else { $erro = 'Erro ao atualizar.'; $acao = 'editar'; }
    }
}

// EXCLUIR
if ($acao === 'excluir') {
    $id = (int) $_GET['id'];
    Categoria::excluir($id);
    $sucesso = 'Categoria excluída.';
    $acao = 'listar';
}

$categorias = array();
$categoria = null;

if ($acao === 'listar') {
    $categorias = Categoria::listarTodas();
}

if ($acao === 'editar') {
    $id = isset($_GET['id']) ? (int)$_GET['id'] : (isset($_POST['id']) ? (int)$_POST['id'] : 0);
    $categoria = Categoria::buscarPorId($id);
    if (!$categoria) { $acao = 'listar'; $categorias = Categoria::listarTodas(); }
}

require_once dirname(__FILE__) . '/../view/categorias.php';
?>
