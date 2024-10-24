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


  <div style="height:80vh; display: flex; flex-direction: row;justify-content: space-evenly;align-items: center;">

    <form action="./register/index.php" method="post">
      <h1 style="margin-bottom: 50px">Cadastro de usuário</h1>
      <div class="mb-3">
        <label for="nome">Nome</label>
        <input name="name" type="text" class="form-control" id="nome" placeholder="Nome">
      </div>
      <div class="mb-3">
        <label for="usuario">Usuario</label>
        <input name="usuario" type="text" class="form-control" id="usuario" placeholder="nome.sobrenome">
      </div>
      <div class="mb-3">
        <label for="senha">Senha</label>
        <input name="password" type="password" class="form-control" id="senha">
      </div>
      <button name="botaoCadastar" class="btn btn-primary" type="submit">Cadastrar</button>
      <hr class="my-4">
    </form>


    <div>
      <?php
      $sql = "SELECT * FROM tb_users";
      $stmt = $conn->prepare($sql);
      $stmt->execute();

      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if ($result) {
        echo "<table class='table table-hover table-striped table-bordered'>";
        echo "<tr><th>#</th><th>Nome</th><th>Usuário</th><th>Criado em</th><th style='text-align: center'>Ações</th></tr>";
        foreach ($result as $row) {
          $id = $row['id'];
          echo "<tr>";
          echo "<td>" . $row['id'] . "</td>";
          echo "<td>" . $row['name'] . "</td>";
          echo "<td>" . $row['user'] . "</td>";
          echo "<td>" . $row['create_at'] . "</td>";
          echo "<td>
              <button onClick=\"location.href='update/index.php?id=$id'\" class='btn btn-success'>Editar</button>
            </td>";
          echo "</tr>";
        }
        echo "</table>";
      } else {
        $_SESSION['msg'] = "Nenhum produto cadastrado";
        exit;
      }
      ?>
    </div>

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