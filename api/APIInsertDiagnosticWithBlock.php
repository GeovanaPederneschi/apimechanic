<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnect.php');

    mysqli_set_charset($con, "utf8");

    $idBloco = $_POST["id_bloco"];
    $idDiagnostico = $_POST["id_diagnostico"];

    $statement = mysqli_prepare($con, 
    "INSERT INTO `auto_mechanic`.`tb_r_enum_bloco_problemas_tb_diagnostico`(`id_tb_enum_bloco_problemas_relatados`,`id_tb_enum_diagnostico`)
    VALUES (?, ?)");

    mysqli_stmt_bind_param($statement,'ii',$idBloco,$idDiagnostico);

    mysqli_stmt_execute($statement);
  
       
        $response["affect_nums"] = mysqli_stmt_affected_rows($statement);
        $response["status"] = true;
    

    echo json_encode($response);
    
} else {

    
    $response["sucesso"] = false;
    
    echo json_encode($response);
}
?>
	