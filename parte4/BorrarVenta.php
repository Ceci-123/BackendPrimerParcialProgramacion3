<?php

include_once "Venta.php";
include_once "Pizza.php";

if (!isset($_DELETE['id'])) {
    parse_str(file_get_contents("php://input"), $post_vars);
    var_dump($post_vars);
    $auxiliarId = $post_vars;

    $listaDeVentas = array();
    $arrayIntermedio = Venta::LeerArchivoJson();
    $listaDeVentas = Venta::jsonToVenta($arrayIntermedio);
    BorrarVenta($auxiliarId, $listaDeVentas);
} else {
    echo "Falta el numero de id para realizar el borrado";
}

function BorrarVenta($id, $lista)
{
    for ($i = 0; $i < count($lista); $i++) {
        if ($lista[$i]->id == $id) {
            $lista[$i]->Mostrar();
            echo "fue eliminada";
            MoverFoto($lista[$i]);

            echo "La foto fue movida";
            unset($lista[$i]);
            Venta::GuardarVentaJson($lista);
            break;
        }
    }
}

function MoverFoto($venta)
{
    $nombre = explode("@", $venta->mailUsuario);
    $nombreDeArchivo = "$venta->tipo - $venta->sabor -$venta->fechaDePedido  - $nombre[0]";
    $viejaCarpeta = "." . DIRECTORY_SEPARATOR . "ImagenesDeLaVenta" . DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR;
    $nuevaCarpeta = "." . DIRECTORY_SEPARATOR . "BACKUPVENTAS" . DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR;
    if (!file_exists($nuevaCarpeta)) {
        mkdir($nuevaCarpeta, 0777, true);
    }
    rename($viejaCarpeta . $nombreDeArchivo . ".jpg", $nuevaCarpeta . $nombreDeArchivo . ".jpg" . "backup");
}
