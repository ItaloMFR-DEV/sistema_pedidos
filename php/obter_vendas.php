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

// Calcular a data de início da semana (segunda-feira)
$startOfWeek = date('Y-m-d', strtotime('monday this week'));
$endOfWeek = date('Y-m-d', strtotime('sunday this week'));

$sql = "SELECT mesa, valor, data_venda FROM vendas WHERE data_venda BETWEEN '$startOfWeek' AND '$endOfWeek'";
$result = $conn->query($sql);

$vendas = [];
while ($row = $result->fetch_assoc()) {
    $vendas[] = [
        'mesa' => $row['mesa'],
        'valor' => $row['valor'],
        'data_venda' => $row['data_venda']
    ];
}

echo json_encode($vendas);

$conn->close();
?>
