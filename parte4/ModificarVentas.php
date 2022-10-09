<?php

include_once "Venta.php";
include_once "Pizza.php";

parse_str(file_get_contents("php://input"), $post_vars);
var_dump($post_vars);
$auxId = $post_vars[0];
var_dump($auxId);
$listaDeVentas = array();
$arrayIntermedio = Venta::LeerArchivoJson();
$listaDeVentas = Venta::jsonToVenta($arrayIntermedio);

ModificarVenta(3, "morenita@gmail.com", "queso", "molde", 4, $listaDeVentas);

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
        } else {
            echo "La venta buscada no existe\n";
        }
    }
}
