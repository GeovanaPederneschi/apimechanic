<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnectLazuli.php');

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    mysqli_set_charset($con, "utf8");

    $idCarrinho = $_POST['id_carrinho'];

    $statement = mysqli_prepare($con, 
    "SELECT * FROM view_localizacao_carrinho_demanda WHERE id_tb_carrinho = ? ORDER BY idtb_localizacao_carrinho DESC LIMIT 1; ");
    mysqli_stmt_bind_param($statement,"i",$idCarrinho);

    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement,
						    $id,
						    $idCarrinhoLocation,
						    $funcionarioId,
						    $numIden,
						    $datatimeRegistroLocation,
						    $x,
                            $y,
                            $idDemanda,
                            $idCarrinhoDemanda,
                            $idColeta,
                            $idEntrega,
                            $statusProgresso,
                            $statusDirecao,
                            $datatimeRegistroDemanda,
                            $datatimeDone
                        ); 
 

    if (mysqli_stmt_num_rows($statement) > 0) {

        while (mysqli_stmt_fetch($statement)) {

            array_push($response, array(
                "idtb_localizacao_carrinho" => $id,
                "id_tb_carrinho" => $idCarrinhoLocation,
                "num_ident" => $numIden,
                "funcionario_id" => $funcionarioId,
                "datatime_registro" => $datatimeRegistroLocation,
                "x_localizacao" => $x,
                "Y_localizacao" => $y,
                "id_demanda" => $idDemanda,
                "status_progresso" => $statusProgresso,
                "status_direction" => $statusDirecao,
                "datatime_cadastro" => $datatimeRegistroDemanda,
                "datatime_finalizado" => $datatimeDone,
                "idPontoColeta" => $idColeta,
                "idPontoEntrega" => $idEntrega,
                "idCarrinhoDemanda" => $idCarrinhoDemanda
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
	