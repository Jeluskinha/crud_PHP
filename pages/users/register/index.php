<?php

session_start();
include_once("../../../venv.php"); // Variaveis de ambiente e conexão com o db

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['botaoCadastar'])) {
  $botaoLogin = htmlspecialchars($_POST['botaoCadastar'], ENT_QUOTES, 'UTF-8');

  $name = $_POST['name'];
  $user = $_POST['usuario'];
  $password = $_POST['password'];
  $status = 1;

  if (!empty($name) &&  !empty($user) &&  !empty($password)) {

    try {
      $sql = "INSERT INTO tb_users (name, user, password, status) VALUES (:name, :user, :password, :status)";

      $stmt = $conn->prepare($sql);

      $stmt->bindParam(':name', $name);
      $stmt->bindParam(':user', $user);
      $stmt->bindParam(':password', $password);
      $stmt->bindParam(':status', $status);
      $stmt->execute();

      $_SESSION['msg'] = 'Usuário Cadastrado';
      header("Location: ../index.php");
      exit;
    } catch (PDOException $e) {
      $_SESSION['msg'] = "Erro: " . $e->getMessage();
      header("Location: ../index.php");
      exit;
    }
  } else { // se o produto não tiver valor retorna este erro    
    $_SESSION['msg'] = 'Insira todos os dados';
    header("Location: ../index.php");
    exit;
  };
}
