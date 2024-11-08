<?php

require "vendor/autoload.php";
require "src/config/Config.php";
require "src/controllers/Leitura_csv.php";

use CoffeeCode\Router\Router;

$router = new Router(URL_BASE);

$router->namespace("src\\controllers");

$router->group(null);

$router->get("/home", "Lercsv:csv");
$router->post("/csv", "Lercsv:teste");

$router->dispatch();

$response = $router->error();
error_log("Resposta do roteador: " . $response);
if ($response) {
    error_log("Erro no roteador: " . $response);
}
