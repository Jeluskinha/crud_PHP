<?php
$servidor = '192.168.5.11';
$usuario = 'app';
$senha = '@ppV1nc45r4s';
$dbname = 'teste_jean';


try {
  $conn = new PDO("mysql:host=$servidor;dbname=$dbname", $usuario, $senha);
  // Set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // echo "Conexão bem-sucedida <br>";
} catch (PDOException $e) {
  echo "Conexão falhou: " . $e->getMessage();
}