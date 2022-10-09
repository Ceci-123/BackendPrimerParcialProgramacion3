<?php

class Venta
{
    public int $id;
    public string $mailUsuario;
    public string $sabor;
    public string $tipo;
    public int $cantidad;
    public string $fechaDePedido;

    public function __construct()
    {
    }

    public function ArmarObjetoVenta($id = 0, $mailUsuario, $sabor, $tipo, $cantidad, $fechaDePedido = "")
    {
        if ($id == 0) {
            $this->id = self::obtenerProximoId();
        } else {
            $this->id = $id;
        }
        $this->mailUsuario = $mailUsuario;
        $this->sabor = $sabor;
        $this->tipo = $tipo;
        $this->cantidad = $cantidad;
        if ($fechaDePedido == "") {
            $fechaActual = new DateTime(date('d-m-y h:i:s'));
            $this->fechaDePedido = $fechaActual->format('y-m-d');
        } else {
            $this->fechaDePedido = $fechaDePedido;
        }
    }

    public function Mostrar()
    {
        echo "$this->numeroDePedido,$this->id,$this->mailUsuario,$this->sabor, $this->tipo,$this->cantidad,$this->fechaDePedido";
    }

    public function obtenerProximoId()
    {
        $proximoId = 0;
        $arrayDeIds = [];
        $ultimoId = 0;
        if (file_exists("Venta.json")) {
            $auxArrayDeJson = Venta::LeerArchivoJson();
            $arrayDeVentas = self::jsonToVenta($auxArrayDeJson);

            foreach ($arrayDeVentas as $Venta) {
                array_push($arrayDeIds, $Venta->id);
            }
            if ($arrayDeIds != null) {
                sort($arrayDeIds);
                $ultimoId = array_pop($arrayDeIds);
                $proximoId = $ultimoId + 1;
            }
        } else {
            $proximoId = 1;
        }
        return $proximoId;
        var_dump($proximoId);
        echo "numero";
    }

    public static function LeerArchivoJson()
    {
        $strJsonFileContents = file_get_contents("Venta.json");
        return $array = json_decode($strJsonFileContents, true);
    }

    public static function jsonToVenta($arrayJson)
    {
        $arrayDeObjetosVenta = [];
        foreach ($arrayJson as $auxJson) {
            $auxId = $auxJson["id"];
            $auxMail = $auxJson["mailUsuario"];
            $auxFecha = $auxJson["fechaDePedido"];
            $auxSabor = $auxJson["_sabor"];
            $auxTipo = $auxJson["_tipo"];
            $auxCantidad = $auxJson["_cantidad"];
            $auxNewVenta = new Venta();
            $auxNewVenta->armarObjetoVenta($auxId, $auxMail, $auxSabor,  $auxTipo, $auxCantidad, $auxFecha);

            array_push($arrayDeObjetosVenta, $auxNewVenta);
        }
        return $arrayDeObjetosVenta;
    }

    public static function GuardarVentaJson($_ArrayVentas)
    {
        $_auxVar = json_encode($_ArrayVentas, JSON_UNESCAPED_SLASHES);
        $auxArchivo = fopen("Venta.json", "w");
        if ($auxArchivo != null) {
            fputs($auxArchivo,  $_auxVar);
            fclose($auxArchivo);
        } else {
            echo "Ocurrio un error al abrir el archivo";
        }
    }

    static function LeerVentasDesdeJSON($nombreArchivo)
    {
        if (file_exists($nombreArchivo)) {
            $archivo = fopen($nombreArchivo, "r");
            $arrayAtributos = array();
            $arrayDeVentas = array();

            if (filesize($nombreArchivo) > 0) {
                $json = fread($archivo, filesize($nombreArchivo));
                $arrayAtributos = json_decode($json, true);

                if (!empty($arrayAtributos)) {
                    foreach ($arrayAtributos as $ventaJson) {
                        $ventaAuxiliar = new Venta(
                            $ventaJson["id"],
                            $ventaJson["mailUsuario"],
                            $ventaJson["_sabor"],
                            $ventaJson["_tipo"],
                            $ventaJson["_cantidad"],
                            $ventaJson["fechaDePedido"]
                        );
                        array_push($arrayDeVentas, $ventaAuxiliar);
                    }
                }
                fclose($archivo);
                return $arrayDeVentas;
            }
        } else {
            echo "El archivo ventas no existe\n";
        }
    }

    public function GuardarImagenVenta()
    {
        $nombre = explode("@", $this->mailUsuario);
        $nombreDeArchivo = "$this->tipo - $this->sabor -$this->fechaDePedido  - $nombre[0]";
        $destino = "ImagenesDeLaVenta/" . $nombreDeArchivo . ".jpg";
        $tmpName = $_FILES["imagen"]["tmp_name"];
        if (move_uploaded_file($tmpName, $destino)) {
            echo "La foto se guardó correctamente\n";
            return true;
        } else {
            echo "La foto no pudo gurdarse";
            return false;
        }
    }
}
