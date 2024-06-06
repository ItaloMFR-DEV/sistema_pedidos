<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistema_pedidos";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mesa = $_POST['mesa'];
    $hora = date('Y-m-d H:i:s');

    $sql = "INSERT INTO mesas (nome, data_criacao) VALUES ('$mesa', '$hora')";
    if ($conn->query($sql) === TRUE) {
        echo "Mesa criada com sucesso";
    } else {
        echo "Erro ao criar mesa: " . $conn->error;
    }
}

$conn->close();
?>
