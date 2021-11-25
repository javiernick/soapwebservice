<?php

require_once "vendor/econea/nusoap/src/nusoap.php";
//require_once "lib/nusoap.php";

$server = new soap_server('def.wsdl');
$server->soap_defencoding = 'ISO-8859-1';
$server->decode_utf8 = false;
$server->debug_flag = false;

function obtenerDatosCentro(){
    $codigoError = "0"; 
    $etiquetaError = "0";

    $nombrefichero = 'centro.json';                 
    if (file_exists($nombrefichero)){
        $xml = getJsonFile($nombrefichero);
    } else {   
        $xml = $this->getArrayXmlFile();
        $xml = $xml['DATOS_IDENTIFICATIVOS'];
    }

    $result = array();
    
    $result['RESPUESTA_DATOS_CENTRO']['CODIGO_RETORNO'] = $codigoError; 
    $result['RESPUESTA_DATOS_CENTRO']['ETIQUETA_ERROR'] = $etiquetaError;
    $result['RESPUESTA_DATOS_CENTRO']['DATOS_IDENTIFICATIVOS'] = $xml; 
    
    return $result;
}

function getJsonFile($filename) {
    
    $str = file_get_contents($filename);    
    $json = json_decode($str, true);     
    return $json;
}

function saveFichero($filename, $content) {
            $f = fopen($filename, 'w');

            fwrite($f, $content);
            fclose($f);


        }


$POST_DATA = file_get_contents("php://input");
$server->service($POST_DATA);
exit();