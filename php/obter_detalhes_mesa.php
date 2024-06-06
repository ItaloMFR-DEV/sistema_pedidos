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
    $mesa_id = $_POST['mesa_id'];

    $sql = "SELECT * FROM pedidos WHERE mesa_id = $mesa_id";
    $result = $conn->query($sql);

    $pedidos = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $pedidos[] = $row;
        }
    }

    echo json_encode($pedidos);
}

$conn->close();
?>
