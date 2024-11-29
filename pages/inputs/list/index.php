<!-- EXEMPLO DE SINTAXE PARA LISTAR INPUTSW, O CÓDIGO ATIVO ESTA DENTRO DA products/index.php -->

<?php

session_start();
include_once("../../../venv.php"); // Variaveis de ambiente e conexão com o db

$sql = "SELECT * FROM tb_input";
$stmt = $conn->prepare($sql);
$stmt->execute();

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($result) {
  echo "<table class='table table-hover table-striped table-bordered'>";
  echo "<tr><th>Fornecedor/Cliente</th><th>responsável</th><th>Produto</th><th>Quantidade</th><th style='text-align: center'>Ações</th></tr>";
  foreach ($result as $row) {
    // encontrando nome do cliente ou fornecedor
    $sql = "SELECT * FROM tb_clifor WHERE id = " . $row['id_clifor'] . " LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $clienteFornecedor = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // encontrando nome do produto
    $sql = "SELECT * FROM tb_users WHERE id = " . $row['id_user'] . " LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $usuario = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //encontrando nome do produto

    $sql = "SELECT * FROM tb_products WHERE id = " . $row['id_product'] . " LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $produto = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $idClifor = $clienteFornecedor[0]['id'];
    $idUser = $usuario[0]['id'];
    $idProduct = $produto[0]['id'];

    echo "<tr>";
    echo  "<td>" . $clienteFornecedor[0]['name'] . "</td>";
    echo  "<td>" . $usuario[0]['user'] . "</td>";
    echo  "<td>" . $produto[0]['description'] . "</td>";
    echo  "<td style='text-align: center'>" . $row['amount'] . "</td>";
    // echo  "<td>
    //         <button onClick=\"location.href='update/index.php?id=$idClifor'\" class='btn btn-success'>Editar</button>
    //       </td>";
    echo  '<td>
            <button onClick="location.href=\'update/index.php?idClifor=' . $idClifor . '&idUser=' . $idUser . '&idProduct=' . $idProduct . '&amount=' . $row['amount'] . ' \'" class=\'btn btn-success\'>Editar</button>
        </td>';
    echo "</tr>";
  }
  echo "</table>";
} else {
  $_SESSION['msg'] = "Nenhum produto cadastrado";
  exit;
}
?>