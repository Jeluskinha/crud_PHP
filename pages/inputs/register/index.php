<?php

session_start();
include_once("../../../venv.php"); // Variaveis de ambiente e conexão com o db

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['botaoCadastar'])) {
  $botaoLogin = htmlspecialchars($_POST['botaoCadastar'], ENT_QUOTES, 'UTF-8');

  $id_clifor = $_POST['id_clifor'];
  $id_user = $_SESSION["id"];
  $id_product = $_POST['id_product'];
  $amount = $_POST['amount'];

  if (empty($amount)) { // se quantidade for fazia ou 0 retorna o errro
    $_SESSION['msg'] = 'Informe a quantidade';
    header("Location: ../index.php");
  }

  try {
    $sql = "INSERT INTO tb_input (id_clifor, id_user, id_product, amount, date) VALUES (:id_clifor, :id_user, :id_product, :amount, :date)";

    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':id_clifor', $id_clifor);
    $stmt->bindParam(':id_user', $id_user);
    $stmt->bindParam(':id_product', $id_product);
    $stmt->bindParam(':amount', $amount);
    $stmt->bindParam(':date', date('Y-m-d'));
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