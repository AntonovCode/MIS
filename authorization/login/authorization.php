<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST") exit;

$body = json_decode(file_get_contents('php://input'), true);

$dsn = "pgsql:host=localhost;port=5432;dbname=test";

$username = $body["login"];
$password = sha1($body["password"]);

$db = new PDO($dsn, "postgres", "admin");
$sql = "select surname, 
               firstname,
               lastname
          from users 
         where username = :username
           and password = :password";
$statement = $db->prepare($sql);

$statement->bindValue(":username", $username, PDO::PARAM_STR);
$statement->bindValue(":password", $password, PDO::PARAM_STR);
$statement->execute();
$row = $statement->fetch(PDO::FETCH_ASSOC);

if ($row) {
    session_start();
    $_SESSION['isAuth'] = true;
    $_SESSION['surname'] = $row["surname"];
    $_SESSION['firstname'] = $row["firstname"];
    $_SESSION['lastname'] = $row["lastname"];
    header('Location: /');
    exit;
} else {
    header('Location: /authorization/login/');
}