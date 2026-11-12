<?php

include "../connection.php";
session_start();

if (!isset($_SESSION["user"])) {
    echo json_encode(["erro" => true, "mensagem" => "Não logado"]);
    exit;
}

$usuario = $_SESSION["user"];

$sql = $conn->prepare("SELECT * FROM extrato WHERE user_id = ? ORDER BY data_operacao DESC");
$sql->execute([$usuario["id"]]);
$lista = $sql->fetchAll();

echo json_encode([
    "erro" => false,
    "extrato" => $lista
]);