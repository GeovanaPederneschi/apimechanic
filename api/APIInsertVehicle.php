<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnect.php');

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    mysqli_set_charset($con, "utf8");

    $data_cadastro = $_POST["cadastro_datetime"];
    $model = $_POST["modelo"];
    $marca = $_POST["marca"];
    $placa = $_POST["placa"];
    $ano = $_POST["ano_fabricacao"];
    $cor = $_POST["cor"];
    $combustivel = $_POST["combustivel"];
    $tracao = $_POST["tracao"];
    $estado = $_POST["estado"];
    $cidade = $_POST["cidade"];
    $over = $_POST["cambio"];
    $tipoCar = $_POST["tipo_veiculo"];

    isset($_POST["chassi"]) ? $chassi = $_POST["chassi"] : $chassi = null;
    isset($_POST["numero_frota"]) ? $numeroFrota = $_POST["numero_frota"] : $numeroFrota = null;
    

    $statement = mysqli_prepare($con, 
    "INSERT INTO `tb_veiculo`(`placa`,`marca`,`cadastro_datatime`,`modelo`,`chassi`,`ano_fabricacao`,`cor`,`tracao`,`combustivel`,`estado`,`cidade`,`numero_frota`,`cambio`,`tipo_veiculo`)
    VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )");


    
    mysqli_stmt_bind_param($statement,"sssssissssssss",$placa,$marca,$data_cadastro,$model,$chassi,$ano,$cor,$tracao,$combustivel,$estado,$cidade,$numeroFrota,$over,$tipoCar);

    mysqli_stmt_execute($statement);
  
       
        $response["affect_nums"] = mysqli_stmt_affected_rows($statement);
  
        $response["sucesso"] = true;
    

    echo json_encode($response);
    
} else {

    
    $response["sucesso"] = false;
    
    echo json_encode($response);
}
?>
	