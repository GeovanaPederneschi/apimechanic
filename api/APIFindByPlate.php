<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnect.php');

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    mysqli_set_charset($con, "utf8");

    $plate = $_POST['placa'];

    $statement = mysqli_prepare($con, 
    "SELECT * from tb_veiculo WHERE `placa` = ?");
    mysqli_stmt_bind_param($statement,"s",$plate);

    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement,
                            $placa,
                            $marca,
                            $cadastro_datatimeVeiculo,
                            $modelo,
                            $chassi,
                            $ano,
                            $cor,
                            $tracao,
                            $combustivel,
                            $estado,
                            $cidade,
                            $numeroFrota,
                            $cambio,
                            $tipoVeiculo
                        ); 
 

    if (mysqli_stmt_num_rows($statement) > 0) {

        while (mysqli_stmt_fetch($statement)) {

            array_push($response, array(
				"placa" => $placa,
                "marca" => $marca,
				"cadastro_datetime" => $cadastro_datatimeVeiculo,
                "modelo" => $modelo,
                "chassi" => $chassi,
                "ano_fabricacao" => $ano,
                "cor" => $cor,
                "combustivel" => $combustivel,
                "tracao" => $tracao,
                "estado" => $estado,
                "cidade" => $cidade,
                "numero_frota" => $numeroFrota,
                "cambio" => $cambio,
                "tipo_veiculo" => $tipoVeiculo
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
	