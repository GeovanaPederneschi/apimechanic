<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnect.php');

    mysqli_set_charset($con, "utf8");

    $idDiagnostico = $_POST["idDiagnostic"];
    $idOrdemFuncionario = $_POST["id_ordem_funcionario"];
    $cpfFuncionario = $_POST["cpf_funcionario"];
    $status = $_POST["status"];
    
    $statement = mysqli_prepare($con, 
    "INSERT INTO `auto_mechanic`.`tb_r_diagnostico_funcionario_ordem`(`id_tb_enum_diagnostico`,`cpf_funcionario`,`id_ordens_funcionario`,`status`)
    VALUES ()");
    
    mysqli_stmt_bind_param($statement,"isis",$idDiagnostico,$cpfFuncionario,$idOrdemFuncionario,$status);

    mysqli_stmt_execute($statement);
  
       
        $response["affect_nums"] = mysqli_stmt_affected_rows($statement);
  
        $response["sucesso"] = true;
    

    echo json_encode($response);
    
} else {

    
    $response["sucesso"] = false;
    
    echo json_encode($response);
}
?>
	