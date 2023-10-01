<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnect.php');

    mysqli_set_charset($con, "utf8");

    $data = $_POST["cadastro_datetime"];

    $statement = mysqli_prepare($con, 
    "SELECT * FROM tb_ordem_servico_procedimento WHERE datetime_cadastro = ?");
    mysqli_stmt_bind_param($statement,"s",$data);

    mysqli_stmt_execute($statement);

    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement,
						    $id,
						    $idUnidade,
						    $idCliente,
                            $placa,
                            $datetimeCadastro,
                            $status
                        ); 
 

    if (mysqli_stmt_num_rows($statement) > 0) {

        while (mysqli_stmt_fetch($statement)) {

            array_push($response, array(
                "idtb_ordem_servico_procedimento" => $id,
				"id_tb_unidade" => $idUnidade,
				"id_tb_cliente" => $idCliente,
                "placa_tb_veiculo" => $placa,
                "datetime_cadastro" => $datetimeCadastro,
                "status_andamento" => $status
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
	