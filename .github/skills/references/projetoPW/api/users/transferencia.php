<?php
include "../connection.php";
session_start();

if (!isset($_SESSION["user"])) {
    echo json_encode(["erro" => true, "mensagem" => "Não logado"]);
    exit;
}

$usuario = $_SESSION["user"];
$emailDestino = $_POST["emailDestino"] ?? "";
$valor = floatval($_POST["valor"] ?? 0);

if (empty($emailDestino) || $valor <= 0) {
    echo json_encode(["erro" => true, "mensagem" => "Dados inválidos"]);
    exit;
}

// Buscar saldo do usuário
$sql = $conn->prepare("SELECT saldo, name FROM users WHERE id = ?");
$sql->execute([$usuario["id"]]);
$remetente = $sql->fetch();

if (!$remetente || $remetente["saldo"] < $valor) {
    echo json_encode(["erro" => true, "mensagem" => "Saldo insuficiente"]);
    exit;
}

// Buscar destinatário
$sql = $conn->prepare("SELECT id, name FROM users WHERE email = ?");
$sql->execute([$emailDestino]);
$destinatario = $sql->fetch();

if (!$destinatario) {
    echo json_encode(["erro" => true, "mensagem" => "Destinatário não encontrado"]);
    exit;
}

$conn->beginTransaction();

try {
    // Atualizar remetente
    $sql = $conn->prepare("UPDATE users SET saldo = saldo - ? WHERE id = ?");
    $sql->execute([$valor, $usuario["id"]]);

    // Atualizar destinatário
    $sql = $conn->prepare("UPDATE users SET saldo = saldo + ? WHERE id = ?");
    $sql->execute([$valor, $destinatario["id"]]);

    // Registrar extrato - remetente
    $sql = $conn->prepare("INSERT INTO extrato (user_id, tipo, valor, descricao) VALUES (?, ?, ?, ?)");
    $sql->execute([
        $usuario["id"],
        "envio",
        $valor,
        "Pix enviado para " . $destinatario["name"]
    ]);

    // Registrar extrato - destinatário
    $sql = $conn->prepare("INSERT INTO extrato (user_id, tipo, valor, descricao) VALUES (?, ?, ?, ?)");
    $sql->execute([
        $destinatario["id"],
        "recebido",
        $valor,
        "Pix recebido de " . $remetente["name"]
    ]);

    $conn->commit();

    echo json_encode(["erro" => false, "mensagem" => "Pix enviado!"]);

} catch (Exception $e) {
    $conn->rollBack();
    echo json_encode(["erro" => true, "mensagem" => "Erro no PIX"]);
}
