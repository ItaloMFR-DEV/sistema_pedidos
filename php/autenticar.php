<?php
session_start();

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

$usuario = $_POST['usuario'];
$senha = $_POST['senha'];

$sql = "SELECT * FROM usuarios WHERE usuario='$usuario' AND senha='$senha'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $_SESSION['loggedin'] = true;
    header("Location: ../admin.html");
} else {
    echo "Usuário ou senha incorretos.";
}

$conn->close();
?>
