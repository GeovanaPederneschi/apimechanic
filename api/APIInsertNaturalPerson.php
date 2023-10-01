<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('Connect.php');

    mysqli_set_charset($con, "utf8");

    $id = $_POST["id"];
    $cpf = $_POST["cpf"];
    isset($_POST["telefone2"]) ? $telefone2 = $_POST["telefone2"] : $telefone2 = null;
    $email = $_POST["email"];
    $nome = $_POST["nome"];
    $telefone1 = $_POST["telefone1"];
    isset($_POST["rg"]) ? $rg = $_POST["rg"] : $rg = null;
    $aniversario = $_POST["aniversario"];

    $statement = mysqli_prepare($con, 
    "INSERT INTO `tb_cliente_fisico`(`cpf`,`id_tb_cliente_tb_cliente_fisico`,`nome`,`data_nascimento`,`rg`,`email`,`telefone1`,`telefone2`)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($statement,"sissssss",$cpf, $id, $nome, $aniversario, $rg, $email, $telefone1, $telefone2);

    mysqli_stmt_execute($statement);
  
       
        $response["affect_nums"] = mysqli_stmt_affected_rows($statement);
  
        $response["sucesso"] = true;
    

    echo json_encode($response);
    
} else {

    
    $response["sucesso"] = false;
    
    echo json_encode($response);
}
?>
	