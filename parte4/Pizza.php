<?php
class Pizza
{
    public $id = 0;
    public $_sabor = "";
    public $_precio = 0;
    public $_tipo = "";
    public $_cantidad = 0;
    public function __construct()
    {
    }
    public function armarObjetoPizza($id = 0, $sabor, $precio, $tipo, $cantidad)
    {
        if ($id == 0) {
            $this->id = self::obtenerProximoId();
        } else {
            $this->id = $id;
        }
        $this->_sabor = $sabor;
        $this->_precio = $precio;
        $this->_tipo = $tipo;
        $this->_cantidad = $cantidad;
    }
    public function obtenerProximoId()
    {
        $proximoId = 0;
        $arrayDeIds = [];
        $ultimoId = 0;
        if (file_exists("Pizza.json")) {
            $auxArrayDeJson = Pizza::LeerArchivoJson();
            $arrayDePizzas = self::jsonToPizza($auxArrayDeJson);
            foreach ($arrayDePizzas as $Pizza) {
                array_push($arrayDeIds, $Pizza->id);
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
    }

    public static function LeerArchivoJson()
    {
        $strJsonFileContents = file_get_contents("Pizza.json");
        return $array = json_decode($strJsonFileContents, true);
    }

    public static function jsonToPizza($arrayJson)
    {
        $arrayDeObjetosPizza = [];
        foreach ($arrayJson as $auxJson) {
            $auxId = $auxJson["id"];
            $auxSabor = $auxJson["_sabor"];
            $auxPrecio = $auxJson["_precio"];
            $auxTipo = $auxJson["_tipo"];
            $auxCantidad = $auxJson["_cantidad"];
            $auxNewPizza = new Pizza();
            $auxNewPizza->armarObjetoPizza($auxId, $auxSabor, $auxPrecio, $auxTipo, $auxCantidad);
            array_push($arrayDeObjetosPizza, $auxNewPizza);
        }
        return $arrayDeObjetosPizza;
    }

    public static function cargarPizza(Pizza $auxPizza)
    {
        if (file_exists("Pizza.json")) {
            $auxArrayDeJson = Pizza::LeerArchivoJson();
            $arrayDePizzas = self::jsonToPizza($auxArrayDeJson);
            if ($arrayDePizzas != null) {
                if (!Pizza::buscarYModificarPizza($auxPizza, $arrayDePizzas)) {
                    array_push($arrayDePizzas, $auxPizza);
                    Pizza::guardarArchivoJson($arrayDePizzas);
                    return true;
                }
            } else {
                echo "ocurrio un error al leer el archivo json";
            }
        } else {
            $auxArrayPizza = [];
            array_push($auxArrayPizza, $auxPizza);
            Pizza::guardarArchivoJson($auxArrayPizza);
            return true;
        }
    }

    public static function buscarYModificarPizza(Pizza $auxPizza, $_arrayDePizzas)
    {
        $returnString = "";
        if ($_arrayDePizzas != null && $auxPizza != null) {
            foreach ($_arrayDePizzas as $value) {
                if ($value->_sabor == $auxPizza->_sabor && $value->_tipo == $auxPizza->_tipo) {
                    $value->_precio = $auxPizza->_precio;
                    $value->_cantidad += $auxPizza->_cantidad;
                    Pizza::guardarArchivoJson($_arrayDePizzas);
                    return true;
                }
            }
            return false;
        } else {
            echo "ocurrio un error al buscar el objeto";
        }
    }

    public static function guardarArchivoJson($_ArrayPizza)
    {
        $_auxVar = json_encode($_ArrayPizza, JSON_UNESCAPED_SLASHES);
        $auxArchivo = fopen("Pizza.json", "w");
        if ($auxArchivo != null) {
            fputs($auxArchivo,  $_auxVar);
            fclose($auxArchivo);
        } else {
            echo "Ocurrio un error al abrir el archivo";
        }
    }

    public static function consultarPizza($tipo, $sabor)
    {
        if ($tipo != null && $sabor != null) {
            if ($tipo == "molde" || $tipo == "piedra") {
                $auxArrayDeJson = Pizza::LeerArchivoJson();
                $arrayDePizza = Pizza::jsonToPizza($auxArrayDeJson);
                if ($arrayDePizza != null) {
                    return Pizza::buscarPizza($arrayDePizza, $tipo, $sabor);
                } else {
                    return "ocurrio un error al buscar el objeto";
                }
            } else {
                return "el tipo solo debe ser piedra o molde";
            }
        }
    }

    public static function buscarPizza($_arrayDePizzas, $tipo, $sabor)
    {
        $returnString = "";
        $totalDeElementos = count($_arrayDePizzas);
        $contador = 0;
        foreach ($_arrayDePizzas as $value) {
            $contador++;
            if ($value->_sabor == $sabor) {
                if ($value->_tipo == $tipo) {
                    $returnString = "Si hay";
                    return $returnString;
                } else {
                    $returnString = "No hay del tipo";
                    return $returnString;
                }
            } else {
                if ($contador == $totalDeElementos) {
                    $returnString = "No hay del sabor";
                    return $returnString;
                }
            }
        }
    }

    public static function BuscaryDevolverPizza($_arrayDePizzas, $tipo, $sabor)
    {
        $totalDeElementos = count($_arrayDePizzas);
        $contador = 0;

        foreach ($_arrayDePizzas as $value) {
            $contador++;
            if ($value->_sabor == $sabor) {

                if ($value->_tipo == $tipo && $value->_cantidad > 0) {
                    return $value;
                } else {
                    return null;
                }
            } else {
                if ($contador == $totalDeElementos) {
                    return null;
                }
            }
        }
    }

    public function Mostrar()
    {
        echo "$this->id,$this->_sabor,$this->_precio,$this->_tipo, $this->_cantidad";
    }
}
