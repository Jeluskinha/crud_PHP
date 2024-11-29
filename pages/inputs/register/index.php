<?php

session_start();
include_once("../../../venv.php"); // Variaveis de ambiente e conexão com o db

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['botaoCadastar'])) {
  $botaoLogin = htmlspecialchars($_POST['botaoCadastar'], ENT_QUOTES, 'UTF-8');

  $id_clifor = $_POST['id_clifor'];
  $id_user = $_SESSION["id"];
  $id_product = $_POST['id_product'];
  $amount = $_POST['amount'];

  // echo '<pre>';
  // print_r(empty($amount));
  // die;

  if (empty($amount) or $amount == 0) { // se quantidade for fazia ou 0 retorna o errro
    $_SESSION['msg'] = 'Informe a quantidade';
    header("Location: ../index.php");
  }

  try {

    // Selecionando input para pegar a quantidade já existente
    $input = "SELECT * FROM tb_input WHERE id_clifor = :id_clifor AND id_user = :id_user AND id_product = :id_product";
    $stmt = $conn->prepare($input);
    $stmt->bindParam(':id_clifor', $id_clifor);
    $stmt->bindParam(':id_user', $id_user);
    $stmt->bindParam(':id_product', $id_product);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (isset($result[0]) == 1) {
      // Somando com o valor da entrada
      $somaValores = $result[0]['amount'] + $amount;

      // Atualizando QUANTIDADE 
      $sql = "UPDATE tb_input SET amount = :amount WHERE id = :idInput";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':amount',  $somaValores);
      $stmt->bindParam(':idInput', $result[0]['id']);
      $stmt->execute();

      $_SESSION['msg'] = 'Entrada atualizada';
      header("Location: ../index.php");
    } else {
      $sql = "INSERT INTO tb_input (id_clifor, id_user, id_product, amount, date) VALUES (:id_clifor, :id_user, :id_product, :amount, :date)";

      $stmt = $conn->prepare($sql);

      $stmt->bindParam(':id_clifor', $id_clifor);
      $stmt->bindParam(':id_user', $id_user);
      $stmt->bindParam(':id_product', $id_product);
      $stmt->bindParam(':amount', $amount);
      $stmt->bindParam(':date', date('Y-m-d'));
      $stmt->execute();

      $_SESSION['msg'] = 'Entrada registrada';
      header("Location: ../index.php");
      exit;
    }
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
