<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistema_pedidos";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT SUM(valor_total) AS total_vendas FROM vendas";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo $row['total_vendas'];
} else {
    echo "0";
}

$conn->close();
?>
