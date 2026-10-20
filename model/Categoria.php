<?php
require_once dirname(__FILE__) . '/../config/database.php';

class Categoria {
    public static function listarTodas() {
        $conn = getConexao();
        $res = $conn->query("SELECT * FROM categorias ORDER BY nome ASC");
        $lista = array();
        while ($row = $res->fetch_assoc()) $lista[] = $row;
        return $lista;
    }

    public static function buscarPorId($id) {
        $conn = getConexao();
        $stmt = $conn->prepare("SELECT * FROM categorias WHERE id = ? LIMIT 1");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $row;
    }

    public static function salvar($nome) {
        $conn = getConexao();
        $stmt = $conn->prepare("INSERT INTO categorias (nome) VALUES (?)");
        $stmt->bind_param("s", $nome);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public static function atualizar($id, $nome) {
        $conn = getConexao();
        $stmt = $conn->prepare("UPDATE categorias SET nome = ? WHERE id = ?");
        $stmt->bind_param("si", $nome, $id);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public static function excluir($id) {
        $conn = getConexao();
        $stmt = $conn->prepare("DELETE FROM categorias WHERE id = ?");
        $stmt->bind_param("i", $id);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }
}
?>
