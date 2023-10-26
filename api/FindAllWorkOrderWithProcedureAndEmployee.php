<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnect.php');

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    mysqli_set_charset($con, "utf8");

    $statement = mysqli_prepare($con, 
    "SELECT * FROM view_ordem_funcionario_dados WHERE status_atribuicao_valida = 'VALID' AND status_andamento_ordem != 'COMPLETED'");

    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement,
                            $idProcedureOrdemFuncionario,
                            $idProcedimentoOrder,
                            $cpfView,
                            $tipoMecanicoView,
                            $atribuicaoDatetime,
                            $statusAtribuicao,
                            $idOrder,
                            $statusAndamentoOrdem,
                            $nomeOrder,
                            $tempoOrder,
                            $modoAtribuicao,
                            $categoriaOrder,
                            $idOrdemProcedimento,
                            $placaVeiculo,
                            $modeloVeiculo,
                            $statusAndamentoProcedimento
                        ); 
 

    if (mysqli_stmt_num_rows($statement) > 0) {

        while (mysqli_stmt_fetch($statement)) {

            array_push($response, array(
                    "idtb_r_ordem_procedimento_ordens_funcionario" => $idProcedureOrdemFuncionario,
                    "id_tb_r_ordem_procedimento_enum_ordens" => $idProcedimentoOrder,
                    "cpf_tb_funcionario_view" => $cpfView,
                    "tipo_mecanico_view" => $tipoMecanicoView,
                    "atribuicao_datetime" => $atribuicaoDatetime,
                    "status_atribuicao_valida" => $statusAtribuicao,
                    "id_tb_enum_ordens"=>$idOrder,
                    "status_andamento_ordem" => $statusAndamentoOrdem,
                    "nome_ordens" => $nomeOrder,
                    "tempo_padrao" => $tempoOrder,
                    "modo_atribuicao" => $modoAtribuicao,
                    "categoria_ordem" => $categoriaOrder,
                    "idtb_ordem_servico_procedimento" => $idOrdemProcedimento,
                    "placa_tb_veiculo" => $placaVeiculo,
                    "modelo_tb_veiculo" => $modeloVeiculo,
                    "status_andamento_procedimento" => $statusAndamentoProcedimento
                )
            );
        }
        
          
          
    } else {
    
           $response["sucesso"] = false;
           $response["error"] = "no queries";
    }

    echo json_encode($response);
    
} else {

    
    $response["sucesso"] = false;
    
    echo json_encode($response);
}
?>
	