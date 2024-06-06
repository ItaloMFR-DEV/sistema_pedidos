<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistema_pedidos";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$produto = $_POST['produto'];
$quantidade = $_POST['quantidade'];
$mesa = $_POST['mesa'];
$descricao = $_POST['descricao'];

// Check if the table exists
$sql = "SELECT * FROM pedidos WHERE mesa='$mesa'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Update existing orders
    $sql = "INSERT INTO pedidos (produto, quantidade, mesa, descricao) VALUES ('$produto', '$quantidade', '$mesa', '$descricao')";
} else {
    // Insert new order
    $sql = "INSERT INTO pedidos (produto, quantidade, mesa, descricao) VALUES ('$produto', '$quantidade', '$mesa', '$descricao')";
}

if ($conn->query($sql) === TRUE) {
    header("Location: ../index.html");  // Redirect to index.html on success
} else {
    echo "Erro: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
