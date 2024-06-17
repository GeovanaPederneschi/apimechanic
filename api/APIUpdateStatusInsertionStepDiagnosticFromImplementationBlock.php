<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnect.php');

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    mysqli_set_charset($con, "utf8");

    $id = $_POST['id'];
    $status = $_POST['status'];

    $statement = mysqli_prepare($con,
    "UPDATE `auto_mechanic`.`tb_r_bloco_problema_funcionario_ordem`SET `status_insercao_passos_diagnostico` = ?
    WHERE `idtb_r_bloco_problema_funcionario_ordem` = ?");

    mysqli_stmt_bind_param($statement,"si",$status, $id);

    mysqli_stmt_execute($statement);
  
       
        $response["affect_nums"] = mysqli_stmt_affected_rows($statement);
  
        $response["sucesso"] = true;
    

    echo json_encode($response);
    
} else {

    
    $response["sucesso"] = false;
    
    echo json_encode($response);
}
?>
	