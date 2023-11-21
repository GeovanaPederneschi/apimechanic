<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnect.php');

    mysqli_set_charset($con, "utf8");

    $id_procedimento = $_POST["id_procedimento_ordem"];
    $cpf = $_POST["cpf"];
    $status = $_POST["status"];
    $cadastroDatetime = $_POST["cadastro_datetime"];

    $statement = mysqli_prepare($con, 
    "UPDATE `tb_r_ordem_procedimento_ordens_funcionario` SET `status_atribuicao_valida` = 'INVALID' WHERE (`id_tb_r_ordem_procedimento_enum_ordens` = ?);
    INSERT INTO `tb_r_ordem_procedimento_ordens_funcionario`(`id_tb_r_ordem_procedimento_enum_ordens`,`cpf_tb_funcionario`,`atribuicao_datetime`,`status_atribuicao_valida`)
    VALUES (?, ?, ?, ?)");
    
    mysqli_stmt_bind_param($statement,"iisss",$id_procedimento,$id_procedimento, $cpf, $cadastroDatetime,$status);

    mysqli_stmt_execute($statement);
  
       
        $response["affect_nums"] = mysqli_stmt_affected_rows($statement);
  
        $response["sucesso"] = true;
    

    echo json_encode($response);
    
} else {

    
    $response["sucesso"] = false;
    
    echo json_encode($response);
}
?>
	