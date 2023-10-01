<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnect.php');

    mysqli_set_charset($con, "utf8");

    $id_unidade = $_POST["id_unidade"];
    $id_cliente = $_POST["id_cliente"];
    $placa = $_POST["placa"];
    $cadastro_datetime = $_POST["cadastro_datetime"];
    $status = $_POST["status"];

    $statement = mysqli_prepare($con, 
    "INSERT INTO `tb_ordem_servico_procedimento`(`id_tb_unidade`,`id_tb_cliente`,`placa_tb_veiculo`,`datetime_cadastro`,`status_andamento`)
    VALUES(?, ?, ?, ?, ?)");
    
    mysqli_stmt_bind_param($statement,"iisss",$id_unidade,$id_cliente,$placa,$cadastro_datetime,$status);

    mysqli_stmt_execute($statement);
  
       
        $response["affect_nums"] = mysqli_stmt_affected_rows($statement);
  
        $response["sucesso"] = true;
    

    echo json_encode($response);
    
} else {

    
    $response["sucesso"] = false;
    
    echo json_encode($response);
}
?>
	