<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnect.php');

    mysqli_set_charset($con, "utf8");

    $id_procedimento = $_POST["id_ordem_procedimento"];
    $id_ordem = $_POST["id_enum_ordem"];
    $status = $_POST["status"];
    $atribuicao = $_POST["tipo_atribuicao"];

    $statement = mysqli_prepare($con, 
    "INSERT INTO `tb_r_ordem_procedimento_enum_ordens`(`id_tb_ordem_servico_procedimento`,`id_tb_enum_ordens`,`status_andamento_ordem`,`tipo_atribuicao`)
    VALUES (?, ?, ?, ?)");
    
    mysqli_stmt_bind_param($statement,"iiss",$id_procedimento, $id_ordem,$status,$atribuicao);


    mysqli_stmt_execute($statement);
  
       
        $response["affect_nums"] = mysqli_stmt_affected_rows($statement);
  
        $response["sucesso"] = true;
    

    echo json_encode($response);
    
} else {

    
    $response["sucesso"] = false;
    
    echo json_encode($response);
}
?>
	