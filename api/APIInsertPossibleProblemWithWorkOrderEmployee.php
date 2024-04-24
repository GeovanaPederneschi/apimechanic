<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnect.php');

    mysqli_set_charset($con, "utf8");

    $idProblema = $_POST["idProblema"];
    $idFuncionario = $_POST["id_ordem_funcionario"];
    $status = $_POST["status"];

    $statement = mysqli_prepare($con, 
    "INSERT INTO `auto_mechanic`.`tb_r_problema_funcionario_ordem`(`id_enum_problema_relatado`,`id_ordens_funcionario`,`status`)
    VALUES ( ?, ?, ?)");

    mysqli_stmt_bind_param($statement,'iis',$idProblema,$idFuncionario,$status);

    mysqli_stmt_execute($statement);
  
       
        $response["affect_nums"] = mysqli_stmt_affected_rows($statement);
        $response["status"] = true;
    

    echo json_encode($response);
    
} else {

    
    $response["sucesso"] = false;
    
    echo json_encode($response);
}
?>
	