<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnect.php');

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    mysqli_set_charset($con, "utf8");

    $idProcedimento = $_POST['id'];

    $statement = mysqli_prepare($con, 
    "SELECT * from  view_procedimento_unidade WHERE idtb_ordem_servico_procedimento = ?");
    mysqli_stmt_bind_param($statement,"i",$idProcedimento);

    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement,
						    $idProcedimento,
						    $idClinte,
                            $placa,
                            $cadastroDatetime,
                            $statusAndamento,
                            $idUnidade,
                            $nomeUnidade,
                            $cep,
                            $rua,
                            $bairro,
                            $uf,
                            $numero,
                            $complemento,
                            $cidade
                        ); 
 

    if (mysqli_stmt_num_rows($statement) > 0) {

        while (mysqli_stmt_fetch($statement)) {

            array_push($response, array(
                "id_tb_unidade" => $idUnidade,
                "nome_unidade" => $nomeUnidade,
                "cep" => $cep,
                "rua" => $rua,
                "bairro" => $bairro,
                "uf_estado" => $uf,
                "numero" => $numero,
                "complemento" => $complemento,
                "cidade" => $cidade
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
	