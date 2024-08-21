<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

           $response["sucesso"] = true;
           $response["ala"] = "ala";

    echo json_encode($response);
    
} else {

    
    $response["sucesso"] = false;
    
    echo json_encode($response);
}
?>
	