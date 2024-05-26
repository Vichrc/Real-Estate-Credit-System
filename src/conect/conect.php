<?php

$host = "localhost";
$db = "db_system_aprova";
$user = "root";
$pass = "";

$mysqli = new mysqli($host, $user, $pass, $db);
if($mysqli->connect_errno) {
    die("Falha ao conectar com o banco de dados");
}