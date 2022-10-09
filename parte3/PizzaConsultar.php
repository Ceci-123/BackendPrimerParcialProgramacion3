
<?php
include "Pizza.php";
if (
    isset($_POST['sabor']) &&
    isset($_POST['tipo'])
) {
    $auxSabor = $_POST['sabor'];
    $auxTipo = $_POST['tipo'];
    echo Pizza::consultarPizza($auxTipo, $auxSabor);
} else {
    $retorno = "Faltan datos por cargar.";
}
