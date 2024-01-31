<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnect.php');

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    mysqli_set_charset($con, "utf8");

    $id = $_POST['id'];
    $idPeca = $_POST['idPeca'];
    $quantidade = $_POST['quantidade'];
    $status = $_POST['status'];

    $statement = mysqli_prepare($con,
    "INSERT INTO `tb_r_ordens_funcionario_peca`(`id_tb_ordens_funcionario`,`id_tb_peca`,`quantidade_peca`,`status_peca`,`datetime_pedido`)
    VALUES(?, ?, ?, ?, now())
    ");
    mysqli_stmt_bind_param($statement,"iiis",$id,$idPeca,$quantidade,$status);

    mysqli_stmt_execute($statement);
  
       
        $response["affect_nums"] = mysqli_stmt_affected_rows($statement);
  
        $response["sucesso"] = true;
    

    echo json_encode($response);
    
} else {

    
    $response["sucesso"] = false;
    
    echo json_encode($response);
}
?>
	