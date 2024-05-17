<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnect.php');

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    mysqli_set_charset($con, "utf8");

    $statement = mysqli_prepare($con, 
    "SELECT * FROM view_outer_problemas_relatados_inserido_funcionario_ordem");

    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement,
						    $idProblema,
						    $problemaRelatado,
                            $tipoInsercao,
                            $idProblemaFuncionarioOrdem,
                            $cpfFuncionario,
                            $idFuncionarioOrdem,
                            $statusInsercao
                        ); 
 

    if (mysqli_stmt_num_rows($statement) > 0) {

        while (mysqli_stmt_fetch($statement)) {

            array_push($response, array(
                "idtb_problemas_relatados" => $id,
				"problema_relatado" => $problemaRelatado,
                "tipo_insercao" => $tipoInsercao,
                "idtb_r_problema_funcionario_ordem" => $idProblemaFuncionarioOrdem,
                "cpf_funcionario" => $cpfFuncionario,
                "id_ordens_funcionario" => $idFuncionarioOrdem,
                "status" => $statusInsercao
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
	