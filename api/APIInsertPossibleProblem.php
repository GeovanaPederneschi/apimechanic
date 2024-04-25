<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnect.php');

    mysqli_set_charset($con, "utf8");

    $problema = $_POST["problema"];
    $tipo_insercao = $_POST["tipo_insercao"];

    $statement = mysqli_prepare($con, 
    "INSERT INTO `tb_enum_problemas_relatados`(`problema_relatado`,`tipo_insercao`)
    VALUES(?, ?)");

    mysqli_stmt_bind_param($statement, 'ss', $problema, $tipo_insercao);
    mysqli_stmt_execute($statement);

    $id = mysqli_insert_id($con);

    $response["idtb_problemas_relatados"] = $id;
    $response["affect_nums"] = mysqli_stmt_affected_rows($statement);

    echo json_encode($response);
    
} else {

    
    $response["sucesso"] = false;
    
    echo json_encode($response);
}
?>
	