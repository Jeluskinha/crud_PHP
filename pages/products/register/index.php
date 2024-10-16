<?php

session_start();
include_once("../../../venv.php"); // Variaveis de ambiente e conexão com o db

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['botaoCadastar'])) {
  $botaoLogin = htmlspecialchars($_POST['botaoCadastar'], ENT_QUOTES, 'UTF-8');

  $description = $_POST['description'];
  $unit = $_POST['unit'];
  $status = 1;

  if (!empty($description)) {
    try {
      $sql = "INSERT INTO tb_products (description, unit, status) VALUES (:description, :unit, :status)";

      $stmt = $conn->prepare($sql);

      $stmt->bindParam(':description', $description);
      $stmt->bindParam(':unit', $unit);
      $stmt->bindParam(':status', $status);
      $stmt->execute();

      $_SESSION['msg'] = 'Produto Cadastrado';
      header("Location: ../index.php");
      exit;
    } catch (PDOException $e) {
      $_SESSION['msg'] = "Erro: " . $e->getMessage();
      header("Location: ../index.php");
      exit;
    }
  } else { // se o produto não tiver valor retorna este erro    
    $_SESSION['msg'] = 'insira o nome do produto';
    header("Location: ../index.php");
    exit;
  };
}
