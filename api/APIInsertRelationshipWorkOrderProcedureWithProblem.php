<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('Connect.php');

    mysqli_set_charset($con, "utf8");

    $id_procedimento = $_POST["id_ordem_procedimento"];
    $id_problema = $_POST["id_problema"];

    $statement = mysqli_prepare($con, 
    "INSERT INTO `auto_mechanic`.`tb_r_ordem_procedimento_enum_problemas` (`id_tb_ordem_servico_procedimento`,`id_tb_enum_problema_relatados`)
    VALUES (?, ?)");
    
    mysqli_stmt_bind_param($statement,"ii",$id_procedimento, $id_problema);

    mysqli_stmt_execute($statement);
  
       
        $response["affect_nums"] = mysqli_stmt_affected_rows($statement);
  
        $response["sucesso"] = true;
    

    echo json_encode($response);
    
} else {

    
    $response["sucesso"] = false;
    
    echo json_encode($response);
}
?>
	