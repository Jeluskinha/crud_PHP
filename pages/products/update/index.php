<!-- AQUI ESTA O COMPONENTE COM O FORMULÁRIO COM OS DADOS PARA ATUALIZAR
eu não consegui chamar uma função para atualizar sem mudar de página, então criei atualizar.php para interagir com o DB e voltar para a páina de PRODUTOS -->

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
  if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM tb_products WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $produto = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($produto) {
      //este código mostra uma cópia do produto que está sendo atualizado
      // echo "ID: " . $produto['id'] . "<br>";
      // echo "Descrição: " . $produto['description'] . "<br>";
      // echo "Unidade: " . $produto['unit'] . "<br>";
      // echo "Status: " . $produto['status'] . "<br>";

      echo '<div style="height:80vh; display: flex; flex-direction: row;justify-content: space-evenly;align-items: center;">';
      echo  '<form action="atualizar.php?id=' . $produto['id'] . '" method="post">';

      // estes inputs enviam o id de forma oculta para a página de atualizar
      // echo    '<input type="hidden" name="acao"';
      // echo    '<input type="hidden" name="id" value=" ' . $produto['id'] . '"';

      echo    '<h1 style="margin-bottom: 50px">Editar Produto</h2>';
      echo    '<div class="mb-3">';
      echo    '<label for="produto">Novo nome</la bel>';
      echo    '<input name="description" type="text" class="form-control" id="produto" placeholder=" ' . $produto['description'] . '">';
      echo  '</div>';
      echo  '<div class="mb-3">';
      echo    '<label for="unidade">Nova Unidade de medida</label>';
      echo    '<select name="unit" id="unidade">';
      echo      '<option value="UN">Un</option>';
      echo      '<option value="KG">Kg</option>';
      echo  '</select>';
      echo  '<button name="botaoAtualizar" class="btn btn-primary" type="submit">Editar</button>';
      echo  '</div>';
      echo  '<hr class="my-4">';
      echo  '<small class="text-body-secondary">Ao clicar em Editar o seu produto será atualizado</small>';
      echo  '</form>';
      echo '</div>';
    }
  }

  ?>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>