<?php

session_start();
include_once("../venv.php"); // Variaveis de ambiente e conexão com o db

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['botaoLogin'])) {
  $botaoLogin = htmlspecialchars($_POST['botaoLogin'], ENT_QUOTES, 'UTF-8');

  // Aqui vai o código para processar o login
  $email = $_POST['email'];
  $password = $_POST['password'];

  if ((!empty($email) and !empty($password))) {
    // echo password_hash($password, PASSWORD_DEFAULT); // Como criar hash de senha

    $sql = "SELECT id, name, user, password, create_at, status FROM tb_users WHERE user = :email LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $result_usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // SESSION funciona como o localStorage do JS, mas como o PHP é linguagem de server side, fica armazenado na sessão do servidor
    $_SESSION["idUsuario"] = $result_usuario['id'];

    if (isset($result_usuario) and $password == $result_usuario['password']) { //encontrando usuário e autenticando
      echo "autenticado.";
      header("Location: ../pages/_home/index.php");
    } else {
      $_SESSION['msg'] = 'Login e senha incorretos';
      header("Location: ../index.php");
      exit;
    }
  } else { // da erro se não informar login ou senha
    $_SESSION['msg'] = 'Informe Login e Senha';
    header("Location: ../index.php");
    exit;
  };
} else {
  // Redirecionar ou exibir uma mensagem de erro
  $_SESSION['msg'] = 'Página não encontrada';
  header("Location: ../index.php");
  exit;
}