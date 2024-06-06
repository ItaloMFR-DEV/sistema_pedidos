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
    $produto = $_POST['produto'];
    $quantidade = $_POST['quantidade'];
    $descricao = $_POST['descricao'];
    $hora = date('Y-m-d H:i:s');

    $sql_produto = "SELECT valor FROM produtos WHERE nome = '$produto'";
    $result_produto = $conn->query($sql_produto);

    if ($result_produto->num_rows > 0) {
        $row = $result_produto->fetch_assoc();
        $valor = $row['valor'];

        $sql = "INSERT INTO pedidos (mesa_id, produto, quantidade, descricao, valor, data_adicao) VALUES ('$mesa_id', '$produto', '$quantidade', '$descricao', '$valor', '$hora')";
        if ($conn->query($sql) === TRUE) {
            echo "Produto adicionado com sucesso";
        } else {
            echo "Erro: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Produto não encontrado";
    }
}

$conn->close();
?>
