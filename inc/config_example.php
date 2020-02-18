<?php

    /* Exibir erros */ 
    ini_set('display_errors', 1); 
    ini_set('display_startup_errors', 1); 
    error_reporting(E_ALL);

    $branch = "Coleta Produção ECA/USP";
    $branch_description = "Coleta produção de diversas fontes para preenchimento do Cadastro de Produção Intelectual, para uso interno da Biblioteca da Escola de Comunicações e Artes da Universidade de São Paulo";
    $url_base = "http://localhost/coletaprod";
    $background_1 = "http://imagens.usp.br/wp-content/uploads/Faculdade-de-Direito-312-15-Foto-Marcos-Santos-028.jpg";
    $facebook_image = "";

    // Definir Instituição
    $instituicao = "USP";

	/* Endereço do server, sem http:// */ 
    $hosts = ['localhost'];

    /* Endereço da BDPI - Para o comparador */
    $host_bdpi = ['localhost'];
    $index_bdpi = "ecafind";
    
    /* Configurações do Elasticsearch */
    $index = "coletaprod";
    $index_cv = "coletaprodcv";
    $index_source = "ecafind";

	/* Load libraries for PHP composer */ 
    require (__DIR__.'/../vendor/autoload.php'); 

	/* Load Elasticsearch Client */ 
	$client = \Elasticsearch\ClientBuilder::create()->setHosts($hosts)->build(); 

    /* Load Elasticsearch Client for BDPI */ 
    $client_bdpi = \Elasticsearch\ClientBuilder::create()->setHosts($host_bdpi)->build(); 
    

    /* Connect Lattes */
    $hostname = "";
    $port = 0000;
    $dbname = "";
    $username = "";
    $pw = "";    


?>