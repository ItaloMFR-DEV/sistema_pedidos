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

$searchTerm = $_GET['term'];
$sql = "SELECT nome FROM produtos WHERE nome LIKE '%".$searchTerm."%'";
$result = $conn->query($sql);

$productNames = [];
while ($row = $result->fetch_assoc()) {
    $productNames[] = $row['nome'];
}

echo json_encode($productNames);

$conn->close();
?>
