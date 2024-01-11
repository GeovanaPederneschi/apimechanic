<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnect.php');

    mysqli_set_charset($con, "utf8");

    $id_procedimento_funcionario = $_POST["id_procedimento_ordem_funcionario"];
    $status = $_POST["status"];

    $statement = mysqli_prepare($con, 
    "INSERT INTO `tb_ordem_diagnostico`
    (`idtb_r_ordem_procedimento_ordens_funcionario`,
    `id_bloco_problema_relatado_escolido`,
    `status_ordem_diagnostico`)
    VALUES (?, null, ?)");
    
    mysqli_stmt_bind_param($statement,"is",$id_procedimento_funcionario, $status);

    mysqli_stmt_execute($statement);
  
       
        $response["affect_nums"] = mysqli_stmt_affected_rows($statement);
  
        $response["sucesso"] = true;
    

    echo json_encode($response);
    
} else {

    
    $response["sucesso"] = false;
    
    echo json_encode($response);
}
?>
	