<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnect.php');

    mysqli_set_charset($con, "utf8");

    $idBloco = $_POST["id_bloco"];
    $idPasso = $_POST["id_passo"];
    
    $statement = mysqli_prepare($con, 
    "INSERT INTO `auto_mechanic`.`tb_r_enum_bloco_problemas_tb_passos_diagnostico`(`id_tb_enum_bloco_problemas_relatados`,`id_tb_enum_passos_diagnostico`)
    VALUES (?, ?)");
    
    mysqli_stmt_bind_param($statement,"ii",$idBloco,$idPasso);

    mysqli_stmt_execute($statement);
  
       
        $response["affect_nums"] = mysqli_stmt_affected_rows($statement);
  
        $response["sucesso"] = true;
    

    echo json_encode($response);
    
} else {

    
    $response["sucesso"] = false;
    
    echo json_encode($response);
}
?>
	