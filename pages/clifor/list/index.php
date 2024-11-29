<!-- EXEMPLO DE SINTAXE PARA LISTAR Clifor, O CÓDIGO ATIVO ESTA DENTRO DA products/index.php -->

<?php
$sql = "SELECT * FROM tb_clifor";
$stmt = $conn->prepare($sql);
$stmt->execute();

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($result) {
  echo "<table class='table table-hover table-striped table-bordered'>";
  echo "<tr><th>#</th><th>Nome</th><th>Criado em</th><th style='text-align: center'>Ações</th></tr>";
  foreach ($result as $row) {
    $id = $row['id'];
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . $row['name'] . "</td>";
    echo "<td>" . $row['create_at'] . "</td>";
    echo "<td>
              <button onClick=\"location.href='update/index.php?id=$id'\" class='btn btn-success'>Editar</button>
            </td>";
    echo "</tr>";
  }
  echo "</table>";
} else {
  $_SESSION['msg'] = "Nenhum produto cadastrado";
  exit;
}
?>