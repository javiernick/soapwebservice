<?php


require_once "lib/nusoap.php";
/*
$server = new soap_server('def.wsdl');
$server->soap_defencoding = 'ISO-8859-1';
$server->decode_utf8 = false;
*/
$URL = "http://certificados.aulacenter.com/soap/index2.php";
$namespace = 'def.wsdl';

$server = new soap_server(); //added ()
$server->debug_flag = false;
$server->configureWSDL('Test', $namespace);



function obtenerDatosCentro(){
    $codigoError = "0"; 
    $etiquetaError = "0";

    $nombrefichero = 'centro.json';                 
    if (file_exists($nombrefichero))
        $xml = getJsonFile($nombrefichero);
    else {   
        $xml = getArrayXmlFile();
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

//$content = file_get_contents('php://input');            
//saveFichero('fichero.xml', $content);

$POST_DATA = file_get_contents("php://input");
$server->service($POST_DATA);
exit();