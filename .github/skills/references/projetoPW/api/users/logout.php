<?php

include "../session.php";

session_start();
unset($_SESSION["user"]);

echo json_encode([
    "message" => "O usuário foi deslogado",
]);