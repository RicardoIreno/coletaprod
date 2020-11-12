<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php"><?php echo $branch; ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Início <span class="sr-only">(atual)</span></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Dashboards
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <?php if (isset($dashboard_lattes_producoes)): ?>
                        <a class="dropdown-item" href="<?php echo $dashboard_lattes_producoes ?>">Produções - Lattes</a>
                    <?php endif ?>
                    <?php if (isset($dashboard_lattes_cv)): ?>
                        <a class="dropdown-item" href="<?php echo $dashboard_lattes_cv ?>">Currículos - Lattes</a>
                    <?php endif ?>
                    <?php if (isset($dashboard_source)): ?>
                        <a class="dropdown-item" href="<?php echo $dashboard_source ?>">Fonte</a>
                    </li>
                    </div>
                </li>



                <?php endif ?>
            </ul>
            <form class="form-inline my-2 my-lg-0" action="result.php">
                <input class="form-control mr-sm-2" type="text" placeholder="Pesquisar" aria-label="Pesquisar" name="search">
                <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Pesquisar</button>
            </form>          
        </div>
    </div>
</nav>