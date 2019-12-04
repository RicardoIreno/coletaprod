<!DOCTYPE html>
<html lang="pt-br" dir="ltr">
    <head>
        <?php 
            include('inc/config.php');             
            include('inc/meta-header-new.php');
            include('inc/functions.php');

        ?> 
        <title>Conversor da API do OpenLibrary</title>     
        
    </head>

    <body>
        <?php require 'inc/navbar.php'; ?>
        <div class="container">        
        

            <?php 

            if (!empty($_GET["isbn"])) {
                echo "<br/><br/><br/><br/><br/>";
                //$query_isbn = $_GET["isbn"];
                //$type = "isbn";
                $resultISBN = DadosExternos::query_openlibrary($_GET["isbn"]);
                if (!empty($resultISBN)) {
                    print_r($resultISBN);
                } else {
                    echo "ISBN não foi encontrado na Base OpenLibrary";
                }
            }

            if (!empty($_GET["sysno"])) {
                $query = $_GET["sysno"];
                $type = "sysno";
            }

            if (!empty($_GET["title"])) {
                $query = [];
                $query[0] = '"'.$_GET["title"].'"';
                if (!empty($_GET["author"])) {
                    $query[1] = '"'.$_GET["author"].'"';
                }
                if (!empty($_GET["year"])) {
                    $query[2] = '"'.$_GET["year"].'"';
                }
                $type = "title";
            }

            ?>

        </div>
            
        <?php include('inc/footer.php'); ?>
        
    </body>
</html>                