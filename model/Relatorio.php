<?php
require_once dirname(__FILE__) . '/../config/database.php';

class Relatorio {
    public static function maisVendidos($limite = 10) {
        $conn = getConexao();
        $stmt = $conn->prepare("
            SELECT p.nome, SUM(iv.quantidade) AS total_vendido, SUM(iv.quantidade * iv.preco_unitario) AS total_receita
            FROM itens_venda iv
            LEFT JOIN produtos p ON p.id = iv.produto_id
            GROUP BY iv.produto_id, p.nome
            ORDER BY total_vendido DESC
            LIMIT ?
        ");
        $stmt->bind_param("i", $limite);
        $stmt->execute();
        $res = $stmt->get_result();
        $lista = array();
        while ($row = $res->fetch_assoc()) $lista[] = $row;
        $stmt->close();
        return $lista;
    }

    public static function estoqueBaixo($minimo = 5) {
        $conn = getConexao();
        $stmt = $conn->prepare("
            SELECT p.nome, p.estoque, c.nome AS categoria_nome
            FROM produtos p
            LEFT JOIN categorias c ON c.id = p.categoria_id
            WHERE p.estoque <= ?
            ORDER BY p.estoque ASC
        ");
        $stmt->bind_param("i", $minimo);
        $stmt->execute();
        $res = $stmt->get_result();
        $lista = array();
        while ($row = $res->fetch_assoc()) $lista[] = $row;
        $stmt->close();
        return $lista;
    }

    public static function totalVendasPorPeriodo() {
        $conn = getConexao();
        $res = $conn->query("
            SELECT DATE_FORMAT(data_venda, '%Y-%m') AS mes,
                   COUNT(*) AS quantidade,
                   SUM(valor_total) AS total
            FROM vendas
            GROUP BY mes
            ORDER BY mes DESC
        ");
        $lista = array();
        while ($row = $res->fetch_assoc()) $lista[] = $row;
        return $lista;
    }
}
?>
