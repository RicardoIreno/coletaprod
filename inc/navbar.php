<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container">
        <a class="navbar-brand" href="<?php echo "$url_base/"?>">Coletaprod ECA/USP</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
            <a class="nav-link" href="<?php echo "$url_base/"?>index.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="#">Busca avançada</a>
            </li>     

            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Login</a>
            <div class="dropdown-menu" aria-labelledby="dropdown01">
                <a class="dropdown-item" href="#">Pesquisar por sua produção</a>
                <a class="dropdown-item" href="#">Dashboard de sua produção</a>
                <a class="dropdown-item" href="#">Exportar sua produçao em formato RIS</a>
                <a class="dropdown-item" href="#">Exportar sua produçao em formato Bibtex</a>
                <a class="dropdown-item" href="#">Acessar a Dashboard</a>
                <a class="dropdown-item" href="#">Logout</a>
            </div>
            </li>
            </ul>
            <form class="form-inline my-2 my-lg-0" action="result.php">
            <input class="form-control mr-sm-2" type="text" placeholder="Pesquisar" aria-label="Pesquisar" name="search[]">
            <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Pesquisar</button>
            </form>          
        </div>
    </div>
</nav>