<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnect.php');

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    mysqli_set_charset($con, "utf8");

    $statement = mysqli_prepare($con,
    "SELECT * FROM view_bloco_problemas_diagnosticos");

    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement,
						    $id,
                            $idBloco,
                            $idDiagnostico,
                            $nomeDiagnostico,
                            $categoriaDiagnostico
                        ); 
 

    if (mysqli_stmt_num_rows($statement) > 0) {

        while (mysqli_stmt_fetch($statement)) {

            array_push($response, array(
                "idtb_r_bloco_problemas_tb_diagnostico" => $id,
                "id_tb_enum_bloco_problemas_relatados" => $idBloco,
                "id_tb_enum_diagnostico" => $idDiagnostico,
                "nome_diagnostico" => $nomeDiagnostico,
				"categoria_diagnostico" => $categoriaDiagnostico
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
	