## TESTE PHP

Opção 1: Desenvolva um programa que exiba uma mensagem diferente para cada dia da
semana, usando o padrão Strategy. Pense que em datas especiais, podemos ter alguma
variação.


# Requisitos
Composer

PHP 8.1

Laravel 9.x
# Instalação

## Clone este repositório
$ git clone https://github.com/baetaDev/ProvaPhp.git

## Instale as dependências
$ composer install

## Execute a aplicação em modo de desenvolvimento

$ php artisan key:generate

$ php artisan serve

http://127.0.0.1:8000/



## VIA DOCKER

Baixar o laradock na raiz do projeto
Ter o Docker Desktop 

git clone https://github.com/Laradock/laradock.git

cd laradock

renomeiar o arquivo da pasta laradock .env.example para .env 

mudar a versão do php para 8.1

docker-compose up -d nginx mysql phpmyadmin redis workspace 

Documentação do laradock: https://laradock.io/

