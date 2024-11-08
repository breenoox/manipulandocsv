<?php

namespace src\models;

use CoffeeCode\DataLayer\DataLayer;

class Produto extends DataLayer
{

    public function __construct()
    {
        parent::__construct("produtos", ["produto", "quantidade", "valor"]);
    }
}
