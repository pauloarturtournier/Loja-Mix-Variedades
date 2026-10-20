<?php
require_once dirname(__FILE__) . '/../config/database.php';

class Produto {
    public static function listarTodos() {
        $conn = getConexao();
        $res = $conn->query("
            SELECT p.*, c.nome AS categoria_nome
            FROM produtos p
            LEFT JOIN categorias c ON c.id = p.categoria_id
            ORDER BY p.nome ASC
        ");
        $lista = array();
        while ($row = $res->fetch_assoc()) $lista[] = $row;
        return $lista;
    }

    public static function buscarPorId($id) {
        $conn = getConexao();
        $stmt = $conn->prepare("SELECT * FROM produtos WHERE id = ? LIMIT 1");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $row;
    }

    public static function salvar($nome, $categoria_id, $preco, $estoque) {
        $conn = getConexao();
        $stmt = $conn->prepare("INSERT INTO produtos (nome, categoria_id, preco, estoque) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sidi", $nome, $categoria_id, $preco, $estoque);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public static function atualizar($id, $nome, $categoria_id, $preco, $estoque) {
        $conn = getConexao();
        $stmt = $conn->prepare("UPDATE produtos SET nome=?, categoria_id=?, preco=?, estoque=? WHERE id=?");
        $stmt->bind_param("sidii", $nome, $categoria_id, $preco, $estoque, $id);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public static function excluir($id) {
        $conn = getConexao();
        $stmt = $conn->prepare("DELETE FROM produtos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public static function baixarEstoque($id, $quantidade) {
        $conn = getConexao();
        $stmt = $conn->prepare("UPDATE produtos SET estoque = estoque - ? WHERE id = ? AND estoque >= ?");
        $stmt->bind_param("iii", $quantidade, $id, $quantidade);
        $ok = $stmt->execute();
        $afetados = $conn->affected_rows;
        $stmt->close();
        return $afetados > 0;
    }

    public static function contarTotal() {
        $conn = getConexao();
        $res = $conn->query("SELECT COUNT(*) AS total FROM produtos");
        $row = $res->fetch_assoc();
        return $row['total'];
    }
}
?>
