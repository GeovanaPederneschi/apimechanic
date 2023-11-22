<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnect.php');

    mysqli_set_charset($con, "utf8");

    $idOrdemProcedimento = $_POST["id"];

    $statement = mysqli_prepare($con, 
    "SELECT * FROM view_revisao_repostas WHERE id_tb_ordem_procedimento_enum_ordens = ?");
    mysqli_stmt_bind_param($statement,"i",$idOrdemProcedimento);

    mysqli_stmt_execute($statement);

    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement,
						    $idRevisaoOrdemFuncionario,
						    $idOrdemFuncionario,
                            $idProcedimentoOrdem,
						    $cadastroDatetime,
                            $idRepostaPergunta,
                            $repostaBoolean,
                            $observacao,
                            $idPergunta,
                            $pergunta
                        ); 
 

    if (mysqli_stmt_num_rows($statement) > 0) {

        while (mysqli_stmt_fetch($statement)) {

            array_push($response, array(
                "idtb_revisao_ordem_funcionario" => $idRevisaoOrdemFuncionario,
				"id_tb_r_ordem_procedimento_ordens_funcionario" => $idOrdemFuncionario,
                "id_tb_ordem_procedimento_enum_ordens" => $idProcedimentoOrdem,
				"datetime_cadastro" => $cadastroDatetime,
                "idtb_r_reposta_revisao_ordem" => $idRepostaPergunta,
                "resposta_boolean" => $repostaBoolean,
                "observacao" => $observacao,
                "idtb_enum_perguntas" => $idPergunta,
                "pergunta_servicos" => $pergunta
                )
            );
        }
    }else{
           $response["sucesso"] = false;
           $response["error"] = "No queries";
    }

    echo json_encode($response);
    
} else {

    
    $response["sucesso"] = false;
    $response["erro"] = "Method Error or App Denied";
    
    echo json_encode($response);
}
?>
	