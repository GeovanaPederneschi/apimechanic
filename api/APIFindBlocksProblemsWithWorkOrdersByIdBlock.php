<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnect.php');

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    mysqli_set_charset($con, "utf8");

    $idBloco = $_POST['idBloco'];

    $statement = mysqli_prepare($con,
    "SELECT * FROM view_bloco_ordens WHERE id_tb_bloco_problema_relatado = ?");
    mysqli_stmt_bind_param($statement,"i",$idBloco);

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
                "idtb_r_tb_ordens_tb_bloco_problema" => $id,
                "id_tb_bloco_problema_relatado" => $idBloco,
                "id_tb_enum_ordens" => $idOrdem,
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
	