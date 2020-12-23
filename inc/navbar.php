<nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark">
  <div class="container">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="index.php"><?php echo $branch; ?></a>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Início</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="result_autores.php">Autores</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dashboards
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <p class="dropdown-item">Usuário: dashboard / Senha: dashboard</p>
            <li>
                <?php if (isset($dashboard_lattes_producoes)) : ?>
                <a class="dropdown-item" href="<?php echo $dashboard_lattes_producoes ?>" target="_blank">Produções - Lattes</a>
                <?php endif ?></li>
            <li>
            <?php if (isset($dashboard_lattes_cv)) : ?>
                <a class="dropdown-item" href="<?php echo $dashboard_lattes_cv ?>" target="_blank">Currículos - Lattes</a>
            <?php endif ?>
            </li>
            <li>
            <?php if (isset($dashboard_source)) : ?>
                <a class="dropdown-item" href="<?php echo $dashboard_source ?>" target="_blank">Fonte</a>
            <?php endif ?>
            </li>
          </ul>
        </li>
      </ul>
      <form class="d-flex" action="result.php">
        <input class="form-control me-2" type="search" placeholder="Pesquisar" aria-label="Pesquisar" name="search">
        <button class="btn btn-outline-success" type="submit">Pesquisar</button>
      </form>
    </div>
  </div>
</nav>