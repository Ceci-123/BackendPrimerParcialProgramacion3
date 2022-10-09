<?php

include_once "Venta.php";
include_once "Pizza.php";

echo "estoy en el put";
parse_str(file_get_contents("php://input"), $post_vars);
var_dump($post_vars);
foreach ($post_vars as $item) {
    var_dump(($item[8]));
    $auxiliarId = ($item[8]);
}


if (isset($_PUT['id'])) { //&& isset($_PUT['mail']) && isset($_PUT['sabor']) && isset($_PUT['tipo']) && isset($_PUT['cantidad'])) {

    echo "que trae";

    $listaDeVentas = array();
    $arrayIntermedio = Venta::LeerArchivoJson();
    $listaDeVentas = Venta::jsonToVenta($arrayIntermedio);
} else {

    echo "Faltan datos para realizar la modificacion";
}
