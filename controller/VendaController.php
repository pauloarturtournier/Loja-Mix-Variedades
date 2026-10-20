<?php
session_start();
if (!isset($_SESSION['usuario_id'])) { header('Location: ../controller/LoginController.php'); exit; }
require_once dirname(__FILE__) . '/../model/Venda.php';
require_once dirname(__FILE__) . '/../model/Produto.php';
require_once dirname(__FILE__) . '/../model/Cliente.php';

$acao = isset($_GET['acao']) ? $_GET['acao'] : 'registrar';
$sucesso = '';
$erro = '';

// REGISTRAR VENDA
if ($acao === 'salvar') {
$cliente_id = isset($_POST['cliente_id']) && $_POST['cliente_id'] !== '' ? (int)$_POST['cliente_id'] : null;
$produtos_id = isset($_POST['produto_id']) ? $_POST['produto_id'] : array();
$quantidades = isset($_POST['quantidade']) ? $_POST['quantidade'] : array();
$precos = isset($_POST['preco_unit']) ? $_POST['preco_unit'] : array();

    $itens = array();
    for ($i = 0; $i < count($produtos_id); $i++) {
        if (!empty($produtos_id[$i]) && $quantidades[$i] > 0) {
            $itens[] = array(
                'produto_id' => (int)$produtos_id[$i],
                'quantidade' => (int)$quantidades[$i],
                'preco_unitario' => (float)$precos[$i]
            );
        }
    }

    if (empty($itens)) {
        $erro = 'Adicione ao menos um produto.'; $acao = 'registrar';
    } else {
        $resultado = Venda::registrar($cliente_id, $itens);
        if ($resultado['ok']) { $sucesso = 'Venda registrada com sucesso!'; $acao = 'registrar'; }
        else { $erro = $resultado['msg']; $acao = 'registrar'; }
    }
}

$produtos = Produto::listarTodos();
$clientes = Cliente::listarTodos();
$vendas   = array();

if ($acao === 'historico') {
    $vendas = Venda::listarHistorico();
}

require_once dirname(__FILE__) . '/../view/vendas.php';
?>
