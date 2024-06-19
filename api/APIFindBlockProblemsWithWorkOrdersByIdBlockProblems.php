<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnect.php');

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    mysqli_set_charset($con, "utf8");

    $idOrdemDiagnostico = $_POST['id'];

    $statement = mysqli_prepare($con,
    "SELECT * FROM auto_mechanic.view_bloco_ordens WHERE id_tb_bloco_problema_relatado = ?");
    mysqli_stmt_bind_param($statement,"i",$idOrdemDiagnostico);

    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement,
						    $id,
                            $idBloco,
                            $idOrdem,
                            $codTSV,
                            $tipoOperacao,
						    $nome,
                            $tempo,
                            $modoAtribuicao,
                            $tipoOrdem
                        ); 
 

    if (mysqli_stmt_num_rows($statement) > 0) {

        while (mysqli_stmt_fetch($statement)) {

            array_push($response, array(
                "idtb_r_bloco_problemas_tb_diagnostico" => $id,
                "id_tb_enum_bloco_problemas_relatados" => $idBloco,
                "id_ordens" => $idOrdem,
                "cod_tsv" => $codTSV,
                "tipo_operacao" => $tipoOperacao,
				"nome_ordens" => $nome,
                "tempo_padrao" => $tempo,
                "modo_atribuicao" => $modoAtribuicao,
                "categoria_ordem" => $tipoOrdem,
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
	