<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnectLazuli.php');

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    mysqli_set_charset($con, "utf8");

    $idCar = $_POST['id_carrinho'];
    
    $statement = mysqli_prepare($con, 
    "SELECT * FROM view_demanda_peca_ponto WHERE status_progresso = 'IN_PROGRESS' and idCarrinho = ?");
    mysqli_stmt_bind_param($statement,"i",$idCar);

    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement,
                            $idDemanda,
                            $idCarrinho,
                            $statusProgresso,
                            $statusDirecao,
                            $horaCadastro,
                            $horaFinalizado,
                            $idDemandaPeca,
                            $idPeca,
                            $quant,
                            $idPontoColeta,
                            $tipoColeta,
                            $xColeta,
                            $yColeta,
                            $idPontoEntrega,
                            $tipoEntrega,
                            $xEntrega,
                            $yEntrega
                        ); 
 

    if (mysqli_stmt_num_rows($statement) > 0) {

        while (mysqli_stmt_fetch($statement)) {

            array_push($response, array(
                "id_tb_demanda" => $idDemanda,
                "idCarrinho" => $idCarrinho,
                "status_progresso" => $statusProgresso,
                "status_direction" => $statusDirecao,
				"datatime_cadastro" => $horaCadastro,
                "datatime_finalizado" => $horaFinalizado,
                "idtb_r_demanda_pecas" => $idDemandaPeca,
                "id_tb_peca" => $idPeca,
                "quantidade" => $quant,
                "idPontoColeta" => $idPontoColeta,
                "tipo_ponto_coleta" => $tipoColeta,
                "x_location_coleta" => $xColeta,
                "y_location_coleta" => $yColeta,
                "idPontoEntrega" => $idPontoEntrega,
                "tipo_ponto_entrega" => $tipoEntrega,
                "x_location_entrega" => $xEntrega,
                "y_location_entrega" => $yEntrega
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
	