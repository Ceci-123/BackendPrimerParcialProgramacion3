<?php

include "Pizza.php";
include "Venta.php";
if (
    isset($_POST['mail']) &&
    isset($_POST['sabor']) &&
    isset($_POST['tipo']) &&
    isset($_POST['cantidad'])
) {
    $auxMail = $_POST['mail'];
    $auxSabor = $_POST['sabor'];
    $auxTipo = $_POST['tipo'];
    $auxCantidad = $_POST['cantidad'];
    RealizarAltaVenta($auxMail, $auxSabor, $auxTipo, $auxCantidad);
} else {
    $retorno = "Faltan datos por cargar.";
}

function RealizarAltaVenta($auxMail, $auxSabor, $auxTipo, $auxCantidad)
{
    $arrayObjetos = Pizza::LeerArchivoJson();
    $arrayPizzas = Pizza::jsonToPizza($arrayObjetos);
    $devolucionPizza = Pizza::BuscaryDevolverPizza($arrayPizzas, $auxTipo, $auxSabor);
    if ($devolucionPizza != null && $devolucionPizza->_cantidad > $auxCantidad) {
        echo "condiciones ok para realizar la alta venta";
        $venta = new Venta();
        $venta->ArmarObjetoVenta(0, $auxMail, $auxSabor, $auxTipo, $auxCantidad);
        $auxNuevaCantidad = $devolucionPizza->_cantidad - $auxCantidad;
        $auxPizza = new Pizza();
        $auxPizza->armarObjetoPizza(0, $devolucionPizza->_sabor, $devolucionPizza->_precio, $devolucionPizza->_tipo, $auxNuevaCantidad);
        Pizza::buscarYModificarPizza($auxPizza, $arrayPizzas);
        Pizza::guardarArchivoJson($arrayPizzas);
        $venta->GuardarImagenVenta();
    } else {
        echo "Las condiciones no son optimas para realizar la alta venta";
    }
}
