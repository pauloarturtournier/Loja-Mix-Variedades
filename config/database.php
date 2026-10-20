<?php
function getConexao() {
    $conexao = new mysqli("localhost", "root", "", "mixtudo");
    if ($conexao->connect_error) {
        die("Erro na conexão: " . $conexao->connect_error);
    }
    $conexao->set_charset("utf8");
    return $conexao;
}
?>
