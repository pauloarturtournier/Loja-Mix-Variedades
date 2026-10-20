<?php
require_once dirname(__FILE__) . '/../config/database.php';
require_once dirname(__FILE__) . '/Produto.php';

class Venda {
    public static function registrar($cliente_id, $itens) {
        // $itens = array( array('produto_id'=>X, 'quantidade'=>Y, 'preco_unitario'=>Z), ... )
        $conn = getConexao();

        // Verificar estoque de todos os itens antes de prosseguir
        foreach ($itens as $item) {
            $stmt = $conn->prepare("SELECT estoque, nome FROM produtos WHERE id = ?");
            $stmt->bind_param("i", $item['produto_id']);
            $stmt->execute();
            $prod = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            if (!$prod || $prod['estoque'] < $item['quantidade']) {
                return array('ok' => false, 'msg' => 'Estoque insuficiente para: ' . ($prod ? $prod['nome'] : 'produto'));
            }
        }

        // Calcular total
        $total = 0;
        foreach ($itens as $item) {
            $total += $item['quantidade'] * $item['preco_unitario'];
        }

        // Inserir venda
        $cliente_id = $cliente_id ? (int)$cliente_id : null;
        if ($cliente_id) {
            $stmt = $conn->prepare("INSERT INTO vendas (cliente_id, valor_total) VALUES (?, ?)");
            $stmt->bind_param("id", $cliente_id, $total);
        } else {
            $stmt = $conn->prepare("INSERT INTO vendas (valor_total) VALUES (?)");
            $stmt->bind_param("d", $total);
        }
        $stmt->execute();
        $venda_id = $conn->insert_id;
        $stmt->close();

        // Inserir itens e baixar estoque
        foreach ($itens as $item) {
            $stmt = $conn->prepare("INSERT INTO itens_venda (venda_id, produto_id, quantidade, preco_unitario) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiid", $venda_id, $item['produto_id'], $item['quantidade'], $item['preco_unitario']);
            $stmt->execute();
            $stmt->close();

            // Baixar estoque
            $stmt2 = $conn->prepare("UPDATE produtos SET estoque = estoque - ? WHERE id = ?");
            $stmt2->bind_param("ii", $item['quantidade'], $item['produto_id']);
            $stmt2->execute();
            $stmt2->close();
        }

        return array('ok' => true, 'venda_id' => $venda_id);
    }

    public static function listarHistorico() {
        $conn = getConexao();
        $res = $conn->query("
            SELECT v.id, v.data_venda, v.valor_total, c.nome AS cliente_nome
            FROM vendas v
            LEFT JOIN clientes c ON c.id = v.cliente_id
            ORDER BY v.data_venda DESC
        ");
        $lista = array();
        while ($row = $res->fetch_assoc()) $lista[] = $row;
        return $lista;
    }

    public static function buscarItensPorVenda($venda_id) {
        $conn = getConexao();
        $stmt = $conn->prepare("
            SELECT iv.quantidade, iv.preco_unitario, p.nome AS produto_nome
            FROM itens_venda iv
            LEFT JOIN produtos p ON p.id = iv.produto_id
            WHERE iv.venda_id = ?
        ");
        $stmt->bind_param("i", $venda_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $lista = array();
        while ($row = $res->fetch_assoc()) $lista[] = $row;
        $stmt->close();
        return $lista;
    }

    public static function contarTotal() {
        $conn = getConexao();
        $res = $conn->query("SELECT COUNT(*) AS total FROM vendas");
        $row = $res->fetch_assoc();
        return $row['total'];
    }

    public static function somarTotal() {
        $conn = getConexao();
        $res = $conn->query("SELECT SUM(valor_total) AS total FROM vendas");
        $row = $res->fetch_assoc();
        return $row['total'] ? $row['total'] : 0;
    }
}
?>
