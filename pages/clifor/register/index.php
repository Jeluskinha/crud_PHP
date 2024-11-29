<?php

session_start();
include_once("../../../venv.php"); // Variaveis de ambiente e conexão com o db

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['botaoCadastar'])) {
  $botaoLogin = htmlspecialchars($_POST['botaoCadastar'], ENT_QUOTES, 'UTF-8');

  $name = $_POST['name'];
  $status = 1;

  if (!empty($name)) {

    try {
      $sql = "INSERT INTO tb_clifor (name, status) VALUES (:name, :status)";

      $stmt = $conn->prepare($sql);

      $stmt->bindParam(':name', $name);
      $stmt->bindParam(':status', $status);
      $stmt->execute();

      $_SESSION['msg'] = 'cliente ou fornecedor Cadastrado';
      header("Location: ../index.php");
      exit;
    } catch (PDOException $e) {
      $_SESSION['msg'] = "Erro: " . $e->getMessage();
      header("Location: ../index.php");
      exit;
    }
  } else { // se o produto não tiver valor retorna este erro    
    $_SESSION['msg'] = 'Informe o cliente ou fornecedor';
    header("Location: ../index.php");
    exit;
  };
}