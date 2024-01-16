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
    "SELECT * FROM tb_r_passo_ordem_diagnostico WHERE id_tb_ordem_diagnostico = ?");
    mysqli_stmt_bind_param($statement,"i",$idOrdemDiagnostico);

    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement,
						    $id,
                            $idDiagnostico,
                            $idPasso,
                            $obs
                        ); 
 

    if (mysqli_stmt_num_rows($statement) > 0) {

        while (mysqli_stmt_fetch($statement)) {

            array_push($response, array(
                "idtb_r_passo_ordem_diagnostico" => $id,
                "idtb_r_passo_ordem_diagnostico" => $idDiagnostico,
                "id_tb_passos_diagnostico" => $idPasso,
				"observacao_passo" => $obs
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
	