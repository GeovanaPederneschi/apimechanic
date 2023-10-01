<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('../dbConnect.php');

    mysqli_set_charset($con, "utf8");

    $tipos_mecanicos = $_POST["tipos_mecanicos"];
    $tipos_mecanicosArray = explode(";",$tipos_mecanicos);

    $tipos = "s";
    $where = "WHERE tipo_mecanico LIKE ?";
    for ($i=1; $i < count($tipos_mecanicosArray); $i++) { 
        $tipos .= "s";
        $where .= " OR tipo_mecanico LIKE ?";
    }

    for ($i=0; $i < count($tipos_mecanicosArray); $i++) {
        $tipos_mecanicosArray[$i] = substr_replace($tipos_mecanicosArray[$i],"%",0,0);
        $tipos_mecanicosArray[$i] = substr_replace($tipos_mecanicosArray[$i],"%",strlen($tipos_mecanicosArray[$i]),0);
    }


    $string = "SELECT * FROM view_outer_ordem_funcionario_dados $where
    AND (status_atribuicao_valida = 'INVALID' OR status_atribuicao_valida IS NULL)";

    $statement = mysqli_prepare($con, $string);

    mysqli_stmt_bind_param($statement,$tipos,...$tipos_mecanicosArray);

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
                            $statusAndamento,
                            $nomeOrder,
                            $tempoOrder,
                            $modoAtribuicao,
                            $categoriaOrder,
                            $cpfFuncionario,
                            $tipoMecanicoFundionario
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
                    "status_andamento" => $statusAndamento,
                    "nome_ordens" => $nomeOrder,
                    "tempo_padrao" => $tempoOrder,
                    "modo_atribuicao" => $modoAtribuicao,
                    "categoria_ordem" => $categoriaOrder,
                    "cpf_tb_funcionario" => $cpfFuncionario,
                    "tipo_mecanico" => $tipoMecanicoFundionario
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