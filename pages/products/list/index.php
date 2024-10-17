<!-- EXEMPLO DE SINTAXE PARA LISTAR PRODUTOS, O CÓDIGO ATIVO ESTA DENTRO DA products/index.php -->

<?php

session_start();
include_once("../../../venv.php"); // Variaveis de ambiente e conexão com o db

$sql = "SELECT * FROM tb_products";
$stmt = $conn->prepare($sql);
$stmt->execute();

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($result) {
  echo "<table class='table table-hover table-striped table-bordered'>";
  echo "<tr><th>#</th><th>Descrição</th><th>Unidade</th><th style='text-align: center'>Ações</th></tr>";
  foreach ($result as $row) {
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . $row['description'] . "</td>";
    echo "<td style='text-align: center'> " . $row['unit'] . "</td>";
    echo "<td>
                  <button class='btn btn-success'>Editar</button>
                  <button class='btn btn-dager'>Excluir</button>
                </td>";
    echo "</tr>";
  }
  echo "</table>";
} else {
  $_SESSION['msg'] = "Nenhum produto cadastrado";
  exit;
}
?>