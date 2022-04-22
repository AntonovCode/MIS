<?php
if ($_SERVER["REQUEST_METHOD"] !== "DELETE") exit;

session_start();
if (empty($_SESSION['isAuth'])) {
    header('Location: /authorization/login/');
    exit;
}

$body = json_decode(file_get_contents('php://input'), true);

$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/includes/pgConnection.php";
include_once($path);

$conn = getPgConnection();
$sql = "delete from users where id = " . $body['userId'];
$conn->exec($sql);

