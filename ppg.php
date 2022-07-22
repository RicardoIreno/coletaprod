<!DOCTYPE html>
<html lang="pt-br" dir="ltr">

<head>
    <?php
  require 'inc/config.php';
  require 'inc/meta-header.php';
  require 'inc/functions.php';
  require 'components/Production.php';

  if (isset($fields)) {
    $_POST["fields"] = $fields;
  }


  $result_post = Requests::postParser($_POST);
  if (!empty($_POST)) {
    $limit = $result_post['limit'];
    $page = $result_post['page'];
    $params = [];
    $params["index"] = $index;
    $params["body"] = $result_post['query'];
    $cursorTotal = $client->count($params);
    $total = $cursorTotal["count"];
    if (isset($_POST["sort"])) {
      $result_post['query']["sort"][$_POST["sort"]]["unmapped_type"] = "long";
      $result_post['query']["sort"][$_POST["sort"]]["missing"] = "_last";
      $result_post['query']["sort"][$_POST["sort"]]["order"] = "desc";
      $result_post['query']["sort"][$_POST["sort"]]["mode"] = "max";
    } else {
      $result_post['query']['sort']['datePublished.keyword']['order'] = "desc";
      $result_post['query']["sort"]["_uid"]["unmapped_type"] = "long";
      $result_post['query']["sort"]["_uid"]["missing"] = "_last";
      $result_post['query']["sort"]["_uid"]["order"] = "desc";
      $result_post['query']["sort"]["_uid"]["mode"] = "max";
    }
    $params["body"] = $result_post['query'];
    $params["size"] = $limit;
    $params["from"] = $result_post['skip'];
    $cursor = $client->search($params);
  } else {
    $limit = 10;
    $page = 1;
    $total = 0;
    $cursor["hits"]["hits"] = [];
  }

  /*pagination - start*/
  $get_data = $_POST;
  /*pagination - end*/

  ?>
    <meta charset="utf-8" />
    <title><?php echo $branch; ?> - Resultado da busca</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <meta name="description" content="Prodmais Unifesp." />
    <meta name="keywords" content="Produção acadêmica, lattes, ORCID" />
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <link rel="stylesheet" href="sass/main.css" />
</head>

<body>
    <?php if(file_exists('inc/google_analytics.php')){include 'inc/google_analytics.php';}?>
   
    <?php require 'inc/navbar.php'; ?>

    <div class="result-container">


    <main>   
    </main>

    </div> <!-- end result-container -->

    <?php include('inc/footer.php'); ?>
    <script>

    </script>
</body>

</html>