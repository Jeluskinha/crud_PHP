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
      <a class="navbar-brand" href="#">Home</a>
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

  <div style="width: 800px; align-self: center; margin: 100px auto">

    <?php
    $sql = "SELECT * FROM tb_input";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $todosInputs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // listando ouputs
    $sql = "SELECT * FROM tb_output";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $todosOutputs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //*******************************************/
    // criando um novo ARRAY de inputs somando os valores repetidos
    $novoInput = array();
    foreach ($todosInputs as $item) {
      $idProduct = $item["id_product"];

      if (!isset($novoInput[$idProduct])) {
        $novoInput[$idProduct] = $item;
      } else {
        $novoInput[$idProduct]["amount"] += $item["amount"];
      }
    }
    // Reindexar o array para ter índices sequenciais
    $novoInput = array_values($novoInput);

    // Criando um novo ARRAY de outputs somando os valores repetidos
    $novoOutput = array();
    foreach ($todosOutputs as $item) {
      $idProduct = $item["id_product"];

      if (!isset($novoOutput[$idProduct])) {
        $novoOutput[$idProduct] = $item;
      } else {
        $novoOutput[$idProduct]["amount"] += $item["amount"];
      }
    }
    // Reindexar o array para ter índices sequenciais
    $novoOutput = array_values($novoOutput);

    // Comparando os dois novos arrays e fazendo o balanço dos valores
    $result = array();

    // Convert `outputs` to a map for easy access
    $outputsMap = array();
    foreach ($novoOutput as $output) {
      $idProduct = $output["id_product"];
      $outputsMap[$idProduct] = $output;
    }

    // Subtrair valores de `inputs` com `outputs`
    foreach ($novoInput as $input) {
      $idProduct = $input["id_product"];

      if (isset($outputsMap[$idProduct])) {
        $input["amount"] -= $outputsMap[$idProduct]["amount"];
        unset($outputsMap[$idProduct]); // Remover do mapa para não ser processado novamente
      }

      $result[] = $input;
    }

    // Adicionar valores de `outputs` restantes como negativos
    foreach ($outputsMap as $output) {
      $output["amount"] = -$output["amount"];
      $result[] = $output;
    }

    //*******************************************/
    // Tabela de Entradas
    if ($novoInput) {
      echo "<h2>Entradas</h2>";
      echo "<table class='table table-hover table-striped table-bordered'>";
      echo "<tr><th>Fornecedor/Cliente</th><th>responsável</th><th>Produto</th><th>Quantidade</th></tr>";
      foreach ($novoInput as $row) {
        // encontrando nome do cliente ou fornecedor
        $sql = "SELECT * FROM tb_clifor WHERE id = " . $row['id_clifor'] . " LIMIT 1";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $clienteFornecedor = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // encontrando nome do produto
        $sql = "SELECT * FROM tb_users WHERE id = " . $row['id_user'] . " LIMIT 1";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $usuario = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //encontrando nome do produto

        $sql = "SELECT * FROM tb_products WHERE id = " . $row['id_product'] . " LIMIT 1";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $produto = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $clienteFornecedor = $clienteFornecedor[0]['name'];
        $usuario = $usuario[0]['user'];
        $produto = $produto[0]['description'];

        echo "<tr>";
        echo  "<td>" . $clienteFornecedor . "</td>";
        echo  "<td>" . $usuario . "</td>";
        echo  "<td>" . $produto . "</td>";
        echo  "<td style='text-align: center'>" .  $row['amount'] . "</td>";
        echo "</tr>";
      }
      echo "</table>";
    } else {
      $_SESSION['msg'] = "Nenhum produto cadastrado";
      exit;
    }
    //*******************************************/
    // Tabela de Saidas
    if ($outputsMap) {
      echo "<h2>Saidas</h2>";
      echo "<table class='table table-hover table-striped table-bordered'>";
      echo "<tr><th>Fornecedor/Cliente</th><th>responsável</th><th>Produto</th><th>Quantidade</th></tr>";
      foreach ($novoOutput as $row) {
        // encontrando nome do cliente ou fornecedor
        $sql = "SELECT * FROM tb_clifor WHERE id = " . $row['id_clifor'] . " LIMIT 1";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $clienteFornecedor = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // encontrando nome do produto
        $sql = "SELECT * FROM tb_users WHERE id = " . $row['id_user'] . " LIMIT 1";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $usuario = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //encontrando nome do produto

        $sql = "SELECT * FROM tb_products WHERE id = " . $row['id_product'] . " LIMIT 1";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $produto = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $clienteFornecedor = $clienteFornecedor[0]['name'];
        $usuario = $usuario[0]['user'];
        $produto = $produto[0]['description'];

        echo "<tr>";
        echo  "<td>" . $clienteFornecedor . "</td>";
        echo  "<td>" . $usuario . "</td>";
        echo  "<td>" . $produto . "</td>";
        echo  "<td style='text-align: center'>" .  $row['amount'] . "</td>";
        echo "</tr>";
      }
      echo "</table>";
    } else {
      $_SESSION['msg'] = "Nenhum produto cadastrado";
      exit;
    }

    //*******************************************/
    // Tabela de Saldo
    if ($result) {
      echo "<h2>Saldo</h2>";
      echo "<table class='table table-hover table-striped table-bordered'>";
      echo "<tr><th>Fornecedor/Cliente</th><th>responsável</th><th>Produto</th><th>Quantidade</th></tr>";

      //LISTANDO O SALDO
      foreach ($result as $row) {
        // encontrando nome do cliente ou fornecedor
        $sql = "SELECT * FROM tb_clifor WHERE id = " . $row['id_clifor'] . " LIMIT 1";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $clienteFornecedor = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // encontrando nome do produto
        $sql = "SELECT * FROM tb_users WHERE id = " . $row['id_user'] . " LIMIT 1";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $usuario = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //encontrando nome do produto

        $sql = "SELECT * FROM tb_products WHERE id = " . $row['id_product'] . " LIMIT 1";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $produto = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $clienteFornecedor = $clienteFornecedor[0]['name'];
        $usuario = $usuario[0]['user'];
        $produto = $produto[0]['description'];

        echo "<tr>";
        echo  "<td>" . $clienteFornecedor . "</td>";
        echo  "<td>" . $usuario . "</td>";
        echo  "<td>" . $produto . "</td>";
        echo  "<td style='text-align: center'>" .  $row['amount'] . "</td>";
        echo "</tr>";
      }
      echo "</table>";
    } else {
      $_SESSION['msg'] = "Nenhum produto cadastrado";
      exit;
    }
    ?>
  </div>


  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>