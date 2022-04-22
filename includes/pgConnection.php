<?php

function getPgConnection() {
    static $db = null;
    if (empty($db)) {
        $dsn = "pgsql:host=localhost;port=5432;dbname=test";
        $username = "postgres";
        $password = "admin";
        $db = new PDO($dsn, $username, $password);
        return $db;
    } else {
        return $db;
    }
}