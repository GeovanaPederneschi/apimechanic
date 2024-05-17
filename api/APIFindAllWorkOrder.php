<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnect.php');

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    mysqli_set_charset($con, "utf8");

    $statement = mysqli_prepare($con, 
    "SELECT * FROM tb_enum_ordens");

    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement,
						    $id,
                            $codTSV,
                            $tipoOperacao,
						    $nome,
                            $tempo,
                            $modoAtribuicao,
                            $tipoOrdem,
                            $tipoSeccao,
                            $tipoInsercao
                        ); 
 

    if (mysqli_stmt_num_rows($statement) > 0) {

        while (mysqli_stmt_fetch($statement)) {

            array_push($response, array(
                "id_ordens" => $id,
                "cod_tsv" => $codTSV,
                "tipo_operacao" => $tipoOperacao,
				"nome_ordens" => $nome,
                "tempo_padrao" => $tempo,
                "modo_atribuicao" => $modoAtribuicao,
                "categoria_ordem" => $tipoOrdem,
                "categoria_seccao" => $tipoSeccao,
                "tipo_insercao" => $tipoInsercao
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
	