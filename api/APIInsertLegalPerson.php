<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnect.php');

    mysqli_set_charset($con, "utf8");

    $id = $_POST["id"];
    $cnpj = $_POST["cnpj"];
    isset($_POST["telefone2"]) ? $telefone2 = $_POST["telefone2"] : $telefone2 = null;
    $razao_social = $_POST["razao_social"];
    $nome_fantasia = $_POST["nome_fantasia"];
    $telefone1 = $_POST["telefone1"];
    isset($_POST["obs"]) ? $obs = $_POST["obs"] : $obs = null;


    $statement = mysqli_prepare($con, 
    "INSERT INTO `tb_cliente_juridico`(`cnpj`,`id_tb_cliente_juridico`,`razao_social`,`nome_fantasia`,`telefone1`,`telefone2`,`obs_adicional`)
    VALUES (?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($statement,"sisssss",$cnpj, $id, $razao_social, $nome_fantasia, $telefone1, $telefone2, $obs);

    mysqli_stmt_execute($statement);
  
       
        $response["affect_nums"] = mysqli_stmt_affected_rows($statement);
  
        $response["sucesso"] = true;
    

    echo json_encode($response);
    
} else {

    
    $response["sucesso"] = false;
    
    echo json_encode($response);
}
?>
	