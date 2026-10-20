<?php
session_start();
if (!isset($_SESSION['usuario_id'])) { header('Location: ../controller/LoginController.php'); exit; }
require_once dirname(__FILE__) . '/../model/Relatorio.php';

$acao = isset($_GET['acao']) ? $_GET['acao'] : 'mais-vendidos';
$dados = array();

if ($acao === 'mais-vendidos')  $dados = Relatorio::maisVendidos();
if ($acao === 'estoque-baixo')  $dados = Relatorio::estoqueBaixo();
if ($acao === 'total-vendas')   $dados = Relatorio::totalVendasPorPeriodo();

require_once dirname(__FILE__) . '/../view/relatorios.php';
?>
