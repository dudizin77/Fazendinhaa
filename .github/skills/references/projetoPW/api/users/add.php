<?php

include "../connection.php";

if (
    !isset($_POST["name"]) ||
    !isset($_POST["email"]) ||
    !isset($_POST["password"]) ||
    empty($_POST["name"]) ||
    empty($_POST["email"]) ||
    empty($_POST["password"])
) {
    echo json_encode([
        "error" => true,
        "message" => "Todos os campos precisam ser preenchidos"
    ]);
    exit;
}

$name = $_POST["name"];
$email = $_POST["email"];
$password = $_POST["password"];

$hash = password_hash($password, PASSWORD_DEFAULT);

// Verifica se já existe
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$email]);
$data = $stmt->fetch();

if ($data) {
    echo json_encode([
        "error" => true,
        "message" => "Usuário já existe",
    ]);
    exit;
}

$saldo = 100.00;

$sql = "INSERT INTO users (name, email, password, saldo) VALUES (:name, :email, :pass, :saldo)";
$stmt = $conn->prepare($sql);
$stmt->execute([
    "name" => $name,
    "email" => $email,
    "pass" => $hash,
    "saldo" => $saldo
]);

echo json_encode([
    "message" => "Usuário inserido com sucesso",
]);