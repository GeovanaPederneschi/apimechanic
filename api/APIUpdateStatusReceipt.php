<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnectLazuli.php');

    mysqli_set_charset($con, "utf8");

    $idDemanda = $_POST["id_demanda"];
    $status = $_POST["status"];

    $statement = mysqli_prepare($con, 
    "UPDATE `deere_challenge`.`tb_demanda`
    SET
    `status_progresso` = ?,
    `datatime_finalizado` = NOW()
    WHERE `id` = ?");
    
    mysqli_stmt_bind_param($statement,"si",$status,$idDemanda);

    mysqli_stmt_execute($statement);
  
       
        $response["affect_nums"] = mysqli_stmt_affected_rows($statement);
  
        $response["sucesso"] = true;
    

    echo json_encode($response);
    
} else {

    
    $response["sucesso"] = false;
    
    echo json_encode($response);
}
?>
	