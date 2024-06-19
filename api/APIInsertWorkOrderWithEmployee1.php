<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnect.php');

    mysqli_set_charset($con, "utf8");

    $idOrdem = $_POST["idOrdem"];
    $idOrdemFuncionario = $_POST["id_ordem_funcionario"];
    $cpfFuncionario = $_POST["cpf_funcionario"];
    $status = $_POST["status"];

    $statement = mysqli_prepare($con, 
    "INSERT INTO `auto_mechanic`.`tb_r_ordem_inserida_funcionario_ordem`(`id_enum_ordem`,`cpf_funcionario`,`id_ordens_funcionario`,`status`)
    VALUES ( ?, ?, ?, ?)");

    mysqli_stmt_bind_param($statement,'isis',$idOrdem,$cpfFuncionario,$idOrdemFuncionario,$status);

    mysqli_stmt_execute($statement);
  
       
        $response["affect_nums"] = mysqli_stmt_affected_rows($statement);
        $response["status"] = true;
    

    echo json_encode($response);
    
} else {

    
    $response["sucesso"] = false;
    
    echo json_encode($response);
}
?>
	