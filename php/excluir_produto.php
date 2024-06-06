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
    $nome = $_POST['nome'];

    $sql = "DELETE FROM produtos WHERE nome = '$nome'";

    if ($conn->query($sql) === TRUE) {
        echo "Produto excluído com sucesso";
    } else {
        echo "Erro ao excluir produto: " . $conn->error;
    }
}

$conn->close();
?>
