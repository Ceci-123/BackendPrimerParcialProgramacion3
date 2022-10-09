<?php
require "Pizza.php";
if (
    isset($_GET['sabor']) &&
    isset($_GET['precio']) &&
    isset($_GET['tipo']) &&
    isset($_GET['cantidad'])
) {
    $auxSabor = strtolower($_GET['sabor']);
    $auxPrecio = $_GET['precio'];
    $auxTipo = strtolower($_GET['tipo']);
    $auxCantidad = $_GET['cantidad'];
    $auxPizza = new Pizza();
    $auxPizza->armarObjetoPizza($auxId = 0, $auxSabor, $auxPrecio, $auxTipo, $auxCantidad);
    if (Pizza::cargarPizza($auxPizza)) {
        echo "Datos guardados correctamente";
    }
} else {
    echo "ocurrió un error al recibir el request";
}
