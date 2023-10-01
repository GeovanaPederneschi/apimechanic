<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('Connect.php');

    mysqli_set_charset($con, "utf8");

    $id = $_POST["id"];
    $cep = $_POST["cep"];
    isset($_POST["endereco_nome"]) ? $nome = $_POST["endereco_nome"] : $nome = null;
    $rua = $_POST["rua"];
    $bairro = $_POST["bairro"];
    $estado = $_POST["estado"];
    $numero = $_POST["numero"];
    isset($_POST["complemento"]) ? $complem = $_POST["complemento"] : $complem = null;
    $cidade = $_POST["cidade"];

    $statement = mysqli_prepare($con, 
    "INSERT INTO `tb_r_endereco_cliente`(`id_cliente_tb_endereco`,`cep`,`nome_endereco`,`rua`,`bairro`,`uf_estado`,`numero`,`complemento`,`cidade`)
    VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($statement,"isssssiss",$id,$cep,$nome,$rua,$bairro,$estado,$numero,$complem,$cidade);

    mysqli_stmt_execute($statement);
  
       
        $response["affect_nums"] = mysqli_stmt_affected_rows($statement);
  
        $response["sucesso"] = true;
    

    echo json_encode($response);
    
} else {

    
    $response["sucesso"] = false;
    
    echo json_encode($response);
}
?>
	