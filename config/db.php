<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "db_biblioteca";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha ao conectar com o banco de dados: " . $conn->connect_error);
}
?>