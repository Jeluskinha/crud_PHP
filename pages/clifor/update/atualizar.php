<!-- É CHAMADO PELO INDEX PARA FAZER A ATUALIZAÇÃO NO DB -->

<?php
session_start();
include_once("../../../venv.php");
?>

<?php

if (isset($_GET['id'])) {
  $id = $_GET['id'];

  $sql = "SELECT * FROM tb_clifor WHERE id = :id";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id', $id);
  $stmt->execute();

  $clifor = $stmt->fetch(PDO::FETCH_ASSOC);

  $botaoAtualizar = htmlspecialchars($_POST['botaoAtualizar'], ENT_QUOTES, 'UTF-8');

  $name = $_POST['name'] ?: $clifor['name'];

  $sql = "UPDATE tb_clifor SET name = :name WHERE id = :id";

  $stmt = $conn->prepare($sql);

  $stmt->bindParam(':id', $id);
  $stmt->bindParam(':name', $name);


  if ($stmt->execute()) {
    $_SESSION['msg'] = 'Cliente ou Fornecedor atualizado';
    header("Location: ../index.php");
    exit;
  } else {
    $_SESSION['msg'] = 'Erro ao atualizar o Cliente ou Fornecedor';
    header("Location: ../index.php");
    exit;
  }
}