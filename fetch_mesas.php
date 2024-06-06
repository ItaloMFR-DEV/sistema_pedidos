<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistema_pedidos";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query para buscar mesas
$sql = "SELECT id, nome FROM mesas";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Saída de dados para cada linha
    while($row = $result->fetch_assoc()) {
        echo '<div class="mesa">';
        echo '<a href="detalhes_mesa.html?mesa_id=' . $row["id"] . '">';
        echo '<h4>' . $row["nome"] . '</h4>';
        echo '</a>';
        echo '</div>';
    }
} else {
    echo "0 results";
}
$conn->close();
?>
