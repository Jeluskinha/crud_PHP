<!-- É CHAMADO PELO INDEX PARA FAZER A ATUALIZAÇÃO NO DB -->

<?php
session_start();
include_once("../../../venv.php");
?>

<?php

if (isset($_GET['id'])) {
  $id = $_GET['id'];

  $sql = "SELECT * FROM tb_users WHERE id = :id";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id', $id);
  $stmt->execute();

  $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

  $_SESSION['msg'] = 'Usuario atualizado';
  $botaoAtualizar = htmlspecialchars($_POST['botaoAtualizar'], ENT_QUOTES, 'UTF-8');

  $name = $_POST['name'] ?: $usuario['name'];
  $user = $_POST['user'] ?: $usuario['user'];
  $password = $_POST['password'] ?: $usuario['password'];

  $sql = "UPDATE tb_users SET name = :name, user = :user, password = :password WHERE id = :id";

  $stmt = $conn->prepare($sql);

  $stmt->bindParam(':id', $id);
  $stmt->bindParam(':name', $name);
  $stmt->bindParam(':user', $user);
  $stmt->bindParam(':password', $password);

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
