<?php
session_start();

if (empty($_SESSION['isAuth'])) {
    header('Location: /authorization/login/');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "GET") exit;

header("Content-Type: application/json");
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/includes/pgConnection.php";
include_once($path);

$conn = getPgConnection();
$sql = "select row_number() OVER() as RN,
               id,
               surname,
               firstname,
               lastname,
               username
          from users";
$statement = $conn->query($sql);

$rows = $statement->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($rows);