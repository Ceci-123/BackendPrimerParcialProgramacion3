<?php
$request = $_SERVER['REQUEST_METHOD'];
$retorno = "Error en el pedido.";
switch ($request) {
    case 'GET':
        include_once "PizzaCarga.php";
        break;
    case 'POST':
        $accion = $_POST["accion"];
        switch ($accion) {
            case "consulta":
                include_once "PizzaConsultar.php";
                break;
            case "venta":
                include_once "AltaVenta.php";
                break;
            case "consultasventas":
                include_once "ConsultasVentas.php";
                break;
        }
        break;
    case 'PUT':


        break;
    case 'DELETE':

        break;
    default:
        return $retorno;
}
