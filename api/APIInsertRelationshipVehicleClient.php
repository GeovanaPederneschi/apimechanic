<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('Connect.php');

    mysqli_set_charset($con, "utf8");

    $id_cliente = $_POST["id_tb_cliente"];
    $placa = $_POST["placa_tb_veiculo"];
    

    $statement = mysqli_prepare($con, 
    "INSERT INTO `tb_r_veiculo_cliente`(`id_tb_cliente`,`placa_tb_veiculo`)
    VALUES(?, ?)");
    
    mysqli_stmt_bind_param($statement,"is",$id_cliente,$placa);

    mysqli_stmt_execute($statement);
  
       
        $response["affect_nums"] = mysqli_stmt_affected_rows($statement);
  
        $response["sucesso"] = true;
    

    echo json_encode($response);
    
} else {

    
    $response["sucesso"] = false;
    
    echo json_encode($response);
}
?>
	