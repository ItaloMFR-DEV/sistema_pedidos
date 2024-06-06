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
    $salvar_venda = $_POST['salvar_venda'];

    if ($salvar_venda) {
        $sql = "SELECT SUM(valor * quantidade) AS valor_total FROM pedidos WHERE mesa_id = $mesa_id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $valor_total = $row['valor_total'];
            $data = date('Y-m-d H:i:s');

            // Verifica se a mesa existe antes de salvar a venda
            $sql_mesa = "SELECT * FROM mesas WHERE id = $mesa_id";
            $result_mesa = $conn->query($sql_mesa);
            if ($result_mesa->num_rows > 0) {
                $sql_insert = "INSERT INTO vendas (mesa_id, valor_total, data_venda) VALUES ('$mesa_id', '$valor_total', '$data')";
                if ($conn->query($sql_insert) !== TRUE) {
                    echo "Erro ao salvar venda: " . $conn->error;
                    $conn->close();
                    exit;
                }
            } else {
                echo "Mesa não encontrada";
                $conn->close();
                exit;
            }
        }
    }

    // Excluir registros relacionados na tabela vendas
    $sql_delete_vendas = "DELETE FROM vendas WHERE mesa_id = $mesa_id";
    if ($conn->query($sql_delete_vendas) !== TRUE) {
        echo "Erro ao excluir vendas: " . $conn->error;
        $conn->close();
        exit;
    }

    // Excluir registros relacionados na tabela pedidos
    $sql_delete_pedidos = "DELETE FROM pedidos WHERE mesa_id = $mesa_id";
    if ($conn->query($sql_delete_pedidos) === TRUE) {
        // Excluir a mesa
        $sql_delete_mesa = "DELETE FROM mesas WHERE id = $mesa_id";
        if ($conn->query($sql_delete_mesa) === TRUE) {
            echo "Mesa excluída com sucesso";
        } else {
            echo "Erro ao excluir mesa: " . $conn->error;
        }
    } else {
        echo "Erro ao excluir pedidos: " . $conn->error;
    }
}

$conn->close();
?>
