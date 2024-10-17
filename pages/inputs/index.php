<?php
session_start();
include_once("../../venv.php");
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
      <a class="navbar-brand" href="../_home/index.php">Home</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
        aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="../products/index.php">produtos </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../users/index.php">usuarios </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../clifor/index.php">clientes e fornecedores</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../inputs/index.php">Entradas </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../outputs/index.php">Saidas</a>
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


  <div style="height:80vh; display: flex; flex-direction: row;justify-content: space-evenly;">

    <form action="./register/index.php" method="post"
      style="display: flex; flex-direction: column;;justify-content: center; gap: 1rem;">
      <h1 style="margin-bottom: 50px; text-align: center">Registrar entrada</h1>
      <div style="display: flex;justify-content: start;gap: 1rem;" class="mb-3">
        <label for="unidade">Cliente / fornecedor</label>
        <select name="unit" id="unidade">
          <option value="CMI">Cliente Mercado Interno</option>
          <option value="VMI">Vendedor Mercado Interno</option>
        </select>
      </div>
      <div style="display: flex;justify-content: space-evenly; gap: 1rem;" class="mb-3">
        <label for="unidade">Produto</label>
        <select name="unit" id="unidade">
          <?php
          $sql = "SELECT * FROM tb_products";
          $stmt = $conn->prepare($sql);
          $stmt->execute();

          $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

          if ($result) {
            foreach ($result as $row) {
              echo '<option value="' . $row['description'] . '">' . $row['description'] . '</option>';
            }
          } else {
            $_SESSION['msg'] = "Nenhum produto cadastrado";
            exit;
          }
          ?>
        </select>
      </div>
      <div style="display: flex;justify-content: start;gap: 1rem;" class="mb-3">
        <label for="nome">Quantidade</label>
        <input name="name" type="number" class="form-control" id="nome">
      </div>
      <button style="align-self: center;" name="botaoCadastar" class="btn btn-primary" type="submit">Cadastrar</button>
      <hr class="my-4">
    </form>

    <!-- 
    <div>
      <?php
      $sql = "SELECT * FROM tb_products";
      $stmt = $conn->prepare($sql);
      $stmt->execute();

      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if ($result) {
        foreach ($result as $row) {
          echo '<option value="' . $row['description'] . '">' . $row['description'] . '</option>';
        }
      } else {
        $_SESSION['msg'] = "Nenhum produto cadastrado";
        exit;
      }
      ?>
    </div> -->

  </div>

  <!-- <nav class="navbar navbar-expand-lg navbar-light bg-light" style="position: absolute;bottom: 0;">
    <div class="container-fluid">
      <a class="navbar-brand" href="../products/index.php">Produtos</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
        aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="../products/index.php">Cadastrar </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../_home/index.php">Atualizar </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../clifor/index.php">Listar</a>
          </li>
        </ul>
      </div>
    </div>
  </nav> -->

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>