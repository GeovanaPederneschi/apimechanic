<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnect.php');

    mysqli_set_charset($con, "utf8");

    $idBloco = $_POST["idBloco"];
    $idOrdemFuncionario = $_POST["id_ordem_funcionario"];
    $cpfFuncionario = $_POST["cpf_funcionario"];
    $status = $_POST["status"];
    $statusInsercaoPassos = $_POST["status_insercao_passos"];
    $statusInsercaoDiagostico = $_POST["status_insercao_diagostico"];
    
    $statement = mysqli_prepare($con, 
    "INSERT INTO `auto_mechanic`.`tb_r_bloco_problema_funcionario_ordem`
    (`id_tb_bloco_problemas_relatados`,`cpf_funcionario`,`id_ordens_funcionario`,`status`,`status_insercao_diagnostico`,`status_insercao_passos_diagnostico`)
    VALUES(?, ?, ?, ?, ?, ?)");
    
    mysqli_stmt_bind_param($statement,"isisss",$idBloco,$cpfFuncionario,$idOrdemFuncionario,$status,$statusInsercaoDiagostico, $statusInsercaoPassos);

    mysqli_stmt_execute($statement);
  
       
        $response["affect_nums"] = mysqli_stmt_affected_rows($statement);
  
        $response["sucesso"] = true;
    

    echo json_encode($response);
    
} else {

    
    $response["sucesso"] = false;
    
    echo json_encode($response);
}
?>
	