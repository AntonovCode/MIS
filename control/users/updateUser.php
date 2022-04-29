<?php
session_start();

if (empty($_SESSION['isAuth'])) {
    header('Location: /authorization/login/');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "PUT") exit;

header("Content-Type: application/json");
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/includes/pgConnection.php";
include_once($path);

$conn = getPgConnection();
$body = json_decode(file_get_contents('php://input'), true);

$sql = "update users set
               surname = :surname,
               firstname = :firstname,
               lastname = :lastname,
               username = :username
         where id = :id";

$statement = $conn->prepare($sql);
$statement->bindValue(":surname",   $body["newSurname"],   PDO::PARAM_STR);
$statement->bindValue(":firstname", $body["newFirstname"], PDO::PARAM_STR);
$statement->bindValue(":lastname",  $body["newLastname"],  PDO::PARAM_STR);
$statement->bindValue(":username",  $body["newUsername"],  PDO::PARAM_STR);
$statement->bindValue(":id",  $body["id"], PDO::PARAM_STR);

$response = [
    "error"   => false
];

try {
    $statement->execute();
} catch (PDOException $e) {
    $response["error"] = "true";
    $response["message"] = "Ошибка в процессе создания пользователя.";
}

echo json_encode($response);