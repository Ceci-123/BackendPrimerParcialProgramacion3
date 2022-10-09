<?php
$request = $_SERVER['REQUEST_METHOD'];
$retorno = "Error en el pedido.";
switch ($request) {
    case 'GET':
        include_once "PizzaCarga.php";
        break;
    case 'POST':
        include_once "PizzaConsultar.php";
        break;
    default:
        return $retorno;
}
