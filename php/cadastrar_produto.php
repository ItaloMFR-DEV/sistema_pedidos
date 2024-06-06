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
    $categoria = $_POST['categoria'];
    $subcategoria = $_POST['subcategoria'];
    $valor = $_POST['valor'];

    $sql = "INSERT INTO produtos (nome, categoria, subcategoria, valor) VALUES ('$nome', '$categoria', '$subcategoria', '$valor')";

    if ($conn->query($sql) === TRUE) {
        echo "Produto cadastrado com sucesso";
    } else {
        echo "Erro ao cadastrar produto: " . $conn->error;
    }
}

$conn->close();
?>
