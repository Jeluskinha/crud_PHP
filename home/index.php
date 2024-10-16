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
      <a class="navbar-brand" href="#">Teste</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
        aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">produtos </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">usuarios </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">clientes e fornecedores</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Entradas </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Saidas</a>
          </li>
        </ul>
        <span class="navbar-text">
          ...
        </span>
      </div>
    </div>
  </nav>

  <div class="container">
    <div class="row">
      <div class="col mt-5">
        <?php
        switch (@$_REQUEST['page']) {
          case "produtos":
            include('produtos.php');
            break;
          case "usuarios":
            include('usuarios.php');
          default:
            print "<h1> Bem vindos! </h1>";
        }
        ?>
      </div>
    </div>
  </div>



  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>