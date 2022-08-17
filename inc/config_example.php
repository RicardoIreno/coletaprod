<?php

/* Exibir erros - Use somente durante os testes */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$branch = "Prodmais";
$branch_description = "Descrição";
$url_base = "http://localhost/prodmais";
$facebook_image = "";
$slogan = 'Uma ferramenta de busca da produção científica de pesquisadores da UNIFESP';

// Definir Instituição
$instituicao = "UNIFESP";

/* Endereço do server, sem http:// */
$hosts = ['localhost'];

/* Configurações do Elasticsearch */
$index = "prodmais";
$index_cv = "prodmaiscv";
$index_authority = "prodmaisaut";

/* Load libraries for PHP composer */
require(__DIR__ . '/../vendor/autoload.php');

/* Load Elasticsearch Client */
$client = \Elasticsearch\ClientBuilder::create()->setHosts($hosts)->build();

/* Login */
$login_user = "admin";
$login_password = "admin";