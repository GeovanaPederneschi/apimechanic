<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnect.php');

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    mysqli_set_charset($con, "utf8");

    $diagnostico = $_POST['diagnostico'];

    $statement = mysqli_prepare($con, 
    "SELECT v.* FROM (SELECT * FROM tb_enum_diagnostico WHERE MATCH(nome_diagnostico) AGAINST (?)) AS d 
    JOIN view_outer_diagnostico_funcionario_ordem AS v ON d.idtb_diagnostico = v.id_tb_enum_diagnostico");
    mysqli_stmt_bind_param($statement,"s",$diagnostico);

    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement,
						    $idDiagnosticoFuncionario,
						    $idDiagnostico,
                            $nomeDiagnostico,
                            $tipoInsercao,
                            $cpfFuncionario,
                            $idFuncionarioOrdem,
                            $statusInsercao
                        ); 
 

    if (mysqli_stmt_num_rows($statement) > 0) {

        while (mysqli_stmt_fetch($statement)) {

            array_push($response, array(
                "idtb_r_diagnostico_funcionario_ordem" => $idDiagnosticoFuncionario,
				"id_tb_enum_diagnostico" => $idDiagnostico,
                "nome_diagnostico" => $nomeDiagnostico,
                "tipo_insercao" => $tipoInsercao,
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
	