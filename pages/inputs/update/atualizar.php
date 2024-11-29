<!-- É CHAMADO PELO INDEX PARA FAZER A ATUALIZAÇÃO NO DB -->

<?php
session_start();
include_once("../../../venv.php");
?>

<?php

$idInput = $_POST['idInput'];
$id_clifor = $_POST['id_clifor'];
$id_user = $_SESSION['id'];
$id_product = $_POST['id_product'];
$amount = $_POST['amount'];

if (isset($idInput) and isset($id_clifor) and isset($id_product) and isset($amount)) {

  $sql = "UPDATE tb_input SET id_clifor = :id_clifor, id_user = :id_user, id_product = :id_product, amount = :amount WHERE id = :idInput";

  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id_clifor', $id_clifor);
  $stmt->bindParam(':id_user', $id_user);
  $stmt->bindParam(':id_product', $id_product);
  $stmt->bindParam(':amount', $amount);
  $stmt->bindParam(':idInput', $idInput);

  if ($stmt->execute()) {
    $_SESSION['msg'] = 'Input atualizado';
    header("Location: ../index.php");
    exit;
  } else {
    $_SESSION['msg'] =  "Erro: " . $e->getMessage();
    header("Location: ../index.php");
    exit;
  }
}
