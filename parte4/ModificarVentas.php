<?php

include_once "Venta.php";
include_once "Pizza.php";

parse_str(file_get_contents("php://input"), $post_vars);
$auxId = $post_vars["id"];
$auxMail = $post_vars["mail"];
$auxSabor = $post_vars["sabor"];
$auxTipo = $post_vars["tipo"];
$auxCantidad = $post_vars["cantidad"];

$listaDeVentas = array();
$arrayIntermedio = Venta::LeerArchivoJson();
$listaDeVentas = Venta::jsonToVenta($arrayIntermedio);

ModificarVenta($auxId, $auxMail, $auxSabor, $auxTipo, $auxCantidad, $listaDeVentas);

function ModificarVenta($id, $mail, $sabor, $tipo, $cantidad, $array)
{
    foreach ($array as $venta) {
        if ($venta->id == $id) {
            echo "Venta a modificar: \n";
            $venta->Mostrar();
            $venta->mailUsuario = $mail;
            $venta->sabor = $sabor;
            $venta->tipo = $tipo;
            $venta->cantidad = $cantidad;
            echo "Nuevos datos de la venta: \n";
            $venta->Mostrar();
            Venta::GuardarVentaJson($array);
            break;
        } else {
            echo "La venta buscada no existe\n";
        }
    }
}
