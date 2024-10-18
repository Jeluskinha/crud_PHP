<!-- AQUI ESTA O COMPONENTE COM O FORMULÁRIO COM OS DADOS PARA ATUALIZAR, ELA É SEMELHANTE A DE CADASTRO -->

<?php
session_start();
include_once("../../../venv.php");
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Projeto PHP</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <!-- navegação -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="../../_home/index.php">Home</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
        aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="../../products/index.php">produtos </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../users/index.php">usuarios </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../clifor/index.php">clientes e fornecedores</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../inputs/index.php">Entradas </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../outputs/index.php">Saidas</a>
          </li>
        </ul>
        <span class="navbar-text">
          ...
        </span>
      </div>
    </div>
  </nav>

  <?php
  if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
  }
  ?>

  <?php
  $idClifor = $_GET['idClifor'];
  $idUser = $_GET['idUser'];
  $idProduct = $_GET['idProduct'];


  if (isset($idClifor) and isset($idUser) and isset($idProduct)) {

    //$sql = "SELECT * FROM tb_input WHERE id_clifor=$idClifor AND id_user=$idUser AND id_product=$idProduct"; 
    //não funciona desse forma ↑ , precisa usar blind bindParam ↓ ↓ exemplo -> :id_product
    $sql = "SELECT * FROM tb_input WHERE id_clifor = :id_clifor AND id_user = :id_user AND id_product = :id_product";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_clifor', $idClifor);
    $stmt->bindParam(':id_user', $idUser);
    $stmt->bindParam(':id_product', $idProduct);
    $stmt->execute();

    $input = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($input) {
      echo '<div style="height:80vh; display: flex; flex-direction: row;justify-content: space-evenly;">';
      echo '<form action="./register/index.php" method="post" style="width: fit-content; display: flex; flex-direction: column;;justify-content: center; gap: 1rem;">';
      echo '<h1 style="margin-bottom: 50px; text-align: center">Registrar entrada</h1>';

      // --------------------- CLIFOR --------------------------------
      echo '<div style="display: flex;justify-content: start;gap: 1rem;" class="mb-3">';
      echo '<label for="unidade">Cliente / fornecedor</label>';
      echo '<select name="id_clifor" id="unidade">';

      // este trecho faz o select para deixar o valor DEFAULT em tb_clifor
      $sql = "SELECT * FROM tb_clifor WHERE id = :id";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':id', $idClifor);
      $stmt->execute();
      $cliforForEdit = $stmt->fetchAll(PDO::FETCH_ASSOC);
      echo '<option value="' . $cliforForEdit[0]['id'] . '" selected>' . $cliforForEdit[0]['name'] . '</option>';
      // **********************

      // AQUI ESTOU PEGANDO O ID E O NOME DA LISTA DE CLIENTE / FORNECEDOR PARA USAR COMO OPTION
      $sql = "SELECT * FROM tb_clifor";
      $stmt = $conn->prepare($sql);
      $stmt->execute();

      $clifor = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if ($clifor) {
        foreach ($clifor as $row) {
          echo '<option value="' . $row['id'] . '" >' . $row['name'] . '</option>';
        }
      } else {
        $_SESSION['msg'] = "Nenhum produto cadastrado";
        exit;
      }
      echo '</select>';
      echo '</div>';

      // --------------------- PRODUCTS --------------------------------
      echo '<div style="display: flex;justify-content: space-evenly; gap: 1rem;" class="mb-3">';
      echo '<label for="unidade">Produto</label>';
      echo '<select name="id_product" id="unidade">';

      // este trecho faz o select para deixar o valor DEFAULT em tb_products
      $sql = "SELECT * FROM tb_products WHERE id = :id";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':id', $idProduct);
      $stmt->execute();
      $productForEdit = $stmt->fetchAll(PDO::FETCH_ASSOC);
      echo '<option value="' . $productForEdit[0]['id'] . '" selected>' . $productForEdit[0]['description'] . '</option>';
      // **********************

      // AQUI ESTOU PEGANDO O ID E O NOME DO PRODUTO PARA USAR COMO OPTION
      $sql = "SELECT * FROM tb_products";
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      $product = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if ($product) {
        foreach ($product as $row) {
          echo '<option value="' . $row['id'] . '">' . $row['description'] . '</option>';
        }
      } else {
        $_SESSION['msg'] = "Nenhum produto cadastrado";
        exit;
      }

      echo '</select>';
      echo '</div>';
      echo '<div style="display: flex;justify-content: start;gap: 1rem;" class="mb-3">';
      echo '<label for="quantidade">Quantidade</label>';

      // colocando o valor default de AMOUNT usando o placeholder
      echo '<input name="amount" type="number" class="form-control" id="quantidade" placeholder="' . $input['amount'] . '">';

      echo '</div>';
      echo '<button style="align-self: center;" name="botaoCadastar" class="btn btn-primary" type="submit">Cadastrar</button>';
      echo '<hr class="my-4">';
      echo '</form>';
      echo '</div>';
    }
  }

  ?>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>