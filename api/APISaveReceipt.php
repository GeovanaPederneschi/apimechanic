<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnectLazuli.php');

    mysqli_set_charset($con, "utf8");

    $idPeca = $_POST["id_peca"];
    $idEntrega = $_POST["id_entrega"];
    $quant = $_POST["quant"];
    

    $statement = mysqli_prepare($con, 
    "InsertDemandaAndPecasManual(?, ?,?)");
    
    mysqli_stmt_bind_param($statement,"iii",$idPeca,$quant,$idEntrega);

    mysqli_stmt_execute($statement);
  
       
        $response["affect_nums"] = mysqli_stmt_affected_rows($statement);
  
        $response["sucesso"] = true;
    

    echo json_encode($response);
    
} else {

    
    $response["sucesso"] = false;
    
    echo json_encode($response);
}
?>
	