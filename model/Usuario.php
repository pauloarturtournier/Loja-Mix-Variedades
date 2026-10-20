<?php
require_once dirname(__FILE__) . '/../config/database.php';

class Usuario {
    public static function buscarPorEmail($email) {
        $conn = getConexao();
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $row ? $row : null;
    }

    public static function verificarSenha($senhaDigitada, $senhaHash) {
        return md5($senhaDigitada) === $senhaHash;
    }

    public static function cadastrar($nome, $email, $senha) {
        $conn = getConexao();
        $senhaHash = md5($senha);
        $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nome, $email, $senhaHash);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
}
?>
