<!-- É CHAMADO PELO INDEX PARA FAZER A ATUALIZAÇÃO NO DB -->

<?php
session_start();
include_once("../../../venv.php");
?>

<?php

if (isset($_GET['id'])) {
  $id = $_GET['id'];

  $sql = "SELECT * FROM tb_products WHERE id = :id";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id', $id);
  $stmt->execute();

  $produto = $stmt->fetch(PDO::FETCH_ASSOC);

  $_SESSION['msg'] = 'Produto atualizado';
  $botaoAtualizar = htmlspecialchars($_POST['botaoAtualizar'], ENT_QUOTES, 'UTF-8');

  $description = $_POST['description'] ?: $produto['description'];
  $unit = $_POST['unit'];
  $status = $produto['status'];

  $sql = "UPDATE tb_products SET description = :description, unit = :unit WHERE id = :id";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id', $id);
  $stmt->bindParam(':description', $description);
  $stmt->bindParam(':unit', $unit);

  if ($stmt->execute()) {
    $_SESSION['msg'] = 'Produto atualizado';
    header("Location: ../index.php");
    exit;
  } else {
    $_SESSION['msg'] = 'Erro ao atualizar o produto';
    header("Location: ../index.php");
    exit;
  }
}