<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnect.php');

    mysqli_set_charset($con, "utf8");

    $idOrdemFuncionario = $_POST["id_ordem_funcionario"];
    $status = $_POST["status"];
    $idBloco = $_POST["id_bloco"];

    $statement = mysqli_prepare($con, 
    "UPDATE `auto_mechanic`.`tb_ordem_diagnostico`
    SET
    `id_bloco_problema_relatado_escolido` = ?,
    `status_ordem_diagnostico` = ?
    WHERE `idtb_r_ordem_procedimento_ordens_funcionario` = ?
    ");
    
    mysqli_stmt_bind_param($statement,"isi",$idBloco, $status,$idOrdemFuncionario);

    mysqli_stmt_execute($statement);
  
       
        $response["affect_nums"] = mysqli_stmt_affected_rows($statement);
  
        $response["sucesso"] = true;
    

    echo json_encode($response);
    
} else {

    
    $response["sucesso"] = false;
    
    echo json_encode($response);
}
?>
	