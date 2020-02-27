# coletaprod
Extração e navegação de registros para a Coleta de Produção Científica das Instituições. 

Fontes possíveis: 

+ Base Lattes
+ Web of Science
+ CrossRef (DOI)

## Dependencias

1. Elasticsearch 7.4 ou superior
* Dependências do PHP: php-cgi | php-curl

## Clonar repositórios

git clone https://github.com/trmurakami/coletaprod.git

## Instalação

curl -s http://getcomposer.org/installer | php

php composer.phar install --no-dev

git submodule init

git submodule update

## Configurar o arquivo inc/config.php

Editar suas configurações em config.php

## Criar indices

Rodar o sistema pela primeira vez para criar os indices

## Comandos para rodar via linha de comando (Se necessário)

php5-cgi -f lattes_json_to_elastic.php id_lattes=XXXXXXXX

php5-cgi -f lattes_json_to_elastic.php path_download=XXXXXXXX

php5-cgi -f lattes_json_to_elastic.php id_lattes=XXXXX tag[]=XXXX unidade[]=XXX numfuncional=XXXXXX

## Rodar documentação

trmurakami@bdpife2:/var/www/html/dev_coletaprod/vendor/phpdocumentor/phpdocumentor/bin$ ./phpdoc -d /var/www/html/dev_coletaprod/inc/ -t /var/www/html/dev_coletaprod/docs --ignore "*/vendor/*,vendor/*"

## Autores:

+ Tiago Rodrigo Marçal Murakami
+ Jan Leduc de Lara


## Como citar

Para citar, use o DOI: 
<a href="https://zenodo.org/badge/latestdoi/3633209"><img src="https://zenodo.org/badge/3633209.svg" alt="DOI"></a>

MURAKAMI, Tiago Rodrigo Marçal & LARA, Jan Leduc de. Coletaprod. Disponível em: < http://doi.org/10.5281/zenodo.3633209 >, Acesso em: 