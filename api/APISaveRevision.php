<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnect.php');

    mysqli_set_charset($con, "utf8");

    $idOrdemProcedimento = $_POST["idOrdemFuncionario"];
    $cadastroDatetime = $_POST["data_registro"];

    $statement = mysqli_prepare($con, 
    "INSERT INTO `tb_revisao_ordem_funcionario`(`id_tb_r_ordem_procedimento_ordens_funcionario`,`datetime_cadastro`)
    VALUES(?, ?)");
    
    mysqli_stmt_bind_param($statement,"is",$idOrdemProcedimento,$cadastroDatetime);

    mysqli_stmt_execute($statement);
  
       
        $response["affect_nums"] = mysqli_stmt_affected_rows($statement);
  
        $response["sucesso"] = true;
    

    echo json_encode($response);
    
} else {

    
    $response["sucesso"] = false;
    
    echo json_encode($response);
}
?>
	