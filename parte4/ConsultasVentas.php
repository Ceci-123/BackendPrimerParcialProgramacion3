<?php
include_once "Venta.php";
include_once "Pizza.php";

if (!isset($_GET['mail']) && !isset($_GET['sabor'])) {
    echo "Faltan datos para realizar la consulta";
}

//leo los datos
$usuarioAFiltrar = $_POST["mail"];
$saborAFiltrar = $_POST["sabor"];
$fechaInicio = ($_POST["inicio"]);
$fechaFinal = ($_POST["final"]);

//inicializo las listas
$listaDePizzas = array();
$arrayIntermedio = Pizza::LeerArchivoJson();
$listaDePizzas = Pizza::jsonToPizza($arrayIntermedio);

$listaDeVentas = array();
$arrayIntermedio = Venta::LeerArchivoJson();
$listaDeVentas = Venta::jsonToVenta($arrayIntermedio);


//consultas
$totalVentas = ConsultaPorCantidad($listaDeVentas);

function ConsultaPorCantidad($array)
{
    $contador = 0;
    foreach ($array as $item) {
        $contador += $item->cantidad;
    }
    return $contador;
}

echo "Se vendieron $totalVentas pizzas\n";

$listaPorUsuario = ConsultaPorUsuario($usuarioAFiltrar, $listaDeVentas);

function ConsultaPorUsuario($nombreUsuario, $array)
{
    $arrayRetorno = [];
    foreach ($array as $item) {
        if ($item->mailUsuario == $nombreUsuario) {
            array_push($arrayRetorno, $item);
        }
    }
    return $arrayRetorno;
}
echo "Ventas del usuario $usuarioAFiltrar :\n";
foreach ($listaPorUsuario as $item) {
    $item->Mostrar();
    echo "\n";
}

$listaPorSabor = ConsultaPorSabor($saborAFiltrar, $listaDeVentas);

function ConsultaPorSabor($sabor, $array)
{
    $arrayRetorno = [];
    foreach ($array as $item) {
        if ($item->sabor == $sabor) {
            array_push($arrayRetorno, $item);
        }
    }
    return $arrayRetorno;
}

echo "Ventas del sabor $saborAFiltrar :\n";
foreach ($listaPorSabor as $item) {
    $item->Mostrar();
    echo "\n";
}

//fechas

$listaPorFechas = ConsultaPorFechas($fechaInicio, $fechaFinal, $listaDeVentas);

function ConsultaPorFechas($fecha1, $fecha2, $array)
{
    $fecha1 = strtotime($fecha1);
    $fecha2 = strtotime($fecha2);

    $arrayRetorno = [];
    foreach ($array as $item) {
        $fechaComparacion = strtotime($item->fechaDePedido);

        if ($fechaComparacion > $fecha1 && $fechaComparacion < $fecha2) {
            array_push($arrayRetorno, $item);
        }
    }
    return $arrayRetorno;
}

echo "entre la fecha $fechaInicio y la fecha $fechaFinal se vendieron los siguientes productos :\n";
foreach ($listaPorFechas as $item) {
    $item->Mostrar();
    echo "\n";
}


// ordenamiento

function Ordenar($array)
{
    $arrayRetorno = $array;
    usort($arrayRetorno, object_sorter('sabor'));
    var_dump($arrayRetorno);
    return $arrayRetorno;
}
/* usort($objDatos, object_sorter('sabor'));
usort($objDatos, object_sorter('sabor', 'DESC')); */


function object_sorter($clave, $orden = null)
{
    return function ($a, $b) use ($clave, $orden) {
        $result =  ($orden == "DESC") ? strnatcmp($b->$clave, $a->$clave) :  strnatcmp($a->$clave, $b->$clave);
        return $result;
    };
}
