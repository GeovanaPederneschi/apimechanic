<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnect.php');

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    mysqli_set_charset($con, "utf8");

    $idOrdemDiagnostico = $_POST['id_ordem'];
    $idPasso = $_POST['id_passo'];
    $observacao = $_POST['obs'];

    $statement = mysqli_prepare($con,
    "INSERT INTO `tb_r_passo_ordem_diagnostico`(`id_tb_ordem_diagnostico`,`id_tb_passos_diagnostico`,`observacao_passo`)
    VALUES (?, ?, ?);
    ");
    mysqli_stmt_bind_param($statement,"iis",$idOrdemDiagnostico,$idPasso,$observacao);

    mysqli_stmt_execute($statement);
  
       
        $response["affect_nums"] = mysqli_stmt_affected_rows($statement);
  
        $response["sucesso"] = true;
    

    echo json_encode($response);
    
} else {

    
    $response["sucesso"] = false;
    
    echo json_encode($response);
}
?>
	