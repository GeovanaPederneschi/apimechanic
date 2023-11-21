<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnect.php');

    mysqli_set_charset($con, "utf8");

    $idOrdemFuncionario = $_POST["idOrdemFuncionario"];
    $idPerguntaOrdem = $_POST["idPerguntaOrdem"];
    $reposta = $_POST["respostaBoolean"];
    $observacao = $_POST["observacao"];

    $statement = mysqli_prepare($con, 
    "INSERT INTO `tb_r_reposta_revisao_ordem`(`id_tb_revisao_ordem_funcionario`,`id_tb_enum_perguntas_ordens`,`resposta_boolean`,`observacao`)
    VALUES (?, ?, ?, ?)");
    
    mysqli_stmt_bind_param($statement,"iiss",$idOrdemFuncionario,$idPerguntaOrdem,$reposta,$observacao);

    mysqli_stmt_execute($statement);
  
       
        $response["affect_nums"] = mysqli_stmt_affected_rows($statement);
  
        $response["sucesso"] = true;
    

    echo json_encode($response);
    
} else {

    
    $response["sucesso"] = false;
    
    echo json_encode($response);
}
?>
	