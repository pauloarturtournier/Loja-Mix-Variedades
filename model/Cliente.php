<?php
require_once dirname(__FILE__) . '/../config/database.php';

class Cliente {
    public static function listarTodos() {
        $conn = getConexao();
        $res = $conn->query("SELECT * FROM clientes ORDER BY nome ASC");
        $lista = array();
        while ($row = $res->fetch_assoc()) $lista[] = $row;
        return $lista;
    }

    public static function buscarPorId($id) {
        $conn = getConexao();
        $stmt = $conn->prepare("SELECT * FROM clientes WHERE id = ? LIMIT 1");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $row;
    }

    public static function salvar($nome, $telefone, $email) {
        $conn = getConexao();
        $stmt = $conn->prepare("INSERT INTO clientes (nome, telefone, email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nome, $telefone, $email);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public static function atualizar($id, $nome, $telefone, $email) {
        $conn = getConexao();
        $stmt = $conn->prepare("UPDATE clientes SET nome=?, telefone=?, email=? WHERE id=?");
        $stmt->bind_param("sssi", $nome, $telefone, $email, $id);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public static function excluir($id) {
        $conn = getConexao();
        $stmt = $conn->prepare("DELETE FROM clientes WHERE id = ?");
        $stmt->bind_param("i", $id);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public static function contarTotal() {
        $conn = getConexao();
        $res = $conn->query("SELECT COUNT(*) AS total FROM clientes");
        $row = $res->fetch_assoc();
        return $row['total'];
    }
}
?>
