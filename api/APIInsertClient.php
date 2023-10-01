<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('Connect.php');

    mysqli_set_charset($con, "utf8");

    $tipo = $_POST["tipo"];
    $data = $_POST["data_registro"];

    $statement = mysqli_prepare($con, 
    "INSERT INTO tb_cliente(data_cadastro,tipo_cliente) VALUES (?, ?)");

    mysqli_stmt_bind_param($statement,'ss',$data,$tipo);

    mysqli_stmt_execute($statement);
  
       
        $response["affect_nums"] = mysqli_stmt_affected_rows($statement);
        $response["status"] = "foi";
    

    echo json_encode($response);
    
} else {

    
    $response["sucesso"] = false;
    
    echo json_encode($response);
}
?>
	