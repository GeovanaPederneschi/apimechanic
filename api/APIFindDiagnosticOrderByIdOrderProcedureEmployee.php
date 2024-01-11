<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnect.php');

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    mysqli_set_charset($con, "utf8");

    $idOrdemFuncionario = $_POST['id_ordem_funcionario'];

    $statement = mysqli_prepare($con,
    "SELECT * FROM tb_ordem_diagnostico WHERE idtb_r_ordem_procedimento_ordens_funcionario = ?");
    mysqli_stmt_bind_param($statement,"i",$idOrdemFuncionario);

    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement,
						    $id,
                            $idOrdemProcedimentoFuncionario,
                            $idBlocoProblema,
                            $status
                        ); 
 

    if (mysqli_stmt_num_rows($statement) > 0) {

        while (mysqli_stmt_fetch($statement)) {

            array_push($response, array(
                "idtb_ordem_diagnostico" => $id,
                "idtb_ordem_diagnostico" => $idOrdemProcedimentoFuncionario,
                "id_bloco_problema_relatado_escolido" => $idBlocoProblema,
                "status_ordem_diagnostico" => $status
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
	