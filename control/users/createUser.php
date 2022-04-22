<?php 

if ($_SERVER["REQUEST_METHOD"] !== "POST") exit;

session_start();
if (empty($_SESSION['isAuth'])) {
    header('Location: /authorization/login/');
    exit;
}

$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/includes/pgConnection.php";
include_once($path);

$conn = getPgConnection();
$body = json_decode(file_get_contents('php://input'), true);
header("Content-Type: application/json");

if (empty($body["surname"])  || empty($body["firstname"]) || 
    empty($body["username"]) || empty($body["password"])) {
    $response = [
        "error"   => true,
        "message" => "Не заполнен обязательный параметр!"
    ];
    echo json_encode($response);
}

$sql = "insert into users (surname, firstname, lastname, username, password)
        values (:surname, :firstname, :lastname, :username, :password)";

$statement = $conn->prepare($sql);
$statement->bindValue(":surname",   $body["surname"],   PDO::PARAM_STR);
$statement->bindValue(":firstname", $body["firstname"], PDO::PARAM_STR);
$statement->bindValue(":lastname",  $body["lastname"],  PDO::PARAM_STR);
$statement->bindValue(":username",  $body["username"],  PDO::PARAM_STR);
$statement->bindValue(":username",  $body["username"],  PDO::PARAM_STR);
$statement->bindValue(":password",  sha1($body["password"]), PDO::PARAM_STR);

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



