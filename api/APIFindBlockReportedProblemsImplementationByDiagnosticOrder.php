<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnect.php');

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    mysqli_set_charset($con, "utf8");

    $idDiagnostico = $_POST['id_diagnostico_ordem'];

    $statement = mysqli_prepare($con,
    "SELECT * FROM auto_mechanic.tb_ordem_diagnostico td
    JOIN view_outer_bloco_problema_relatado_inserido_funcionario_ordem v
    ON td.id_bloco_problema_relatado_escolido = v.id_tb_bloco_problemas_relatados WHERE td.idtb_ordem_diagnostico = ?");

    mysqli_stmt_bind_param($statement,"i",$idDiagnostico);

    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement,
						    $idOrdemDiagnostico,
                            $idFuncionarioOrdemDiagnostico,
                            $idBlocoProblemaDiagnostico,
                            $statusDiagnostico,
                            $idBlocoFuncionarioOrdem,
                            $idBlocoProblemaView,
                            $tipoInsercao,
                            $cpfFuncionario,
                            $idOrdemFuncionarioView,
                            $statusBlocoOrdemFuncionario,
                            $statusInsercaoDiagnostico,
                            $statusInsercaoPassos,
                            $statusInsercaoOrdens
                        ); 
 

    if (mysqli_stmt_num_rows($statement) > 0) {

        while (mysqli_stmt_fetch($statement)) {

            array_push($response, array(
                "id_tb_enum_diagnostico" => $idOrdemDiagnostico,
                "idtb_r_ordem_procedimento_ordens_funcionario" => $idFuncionarioOrdemDiagnostico,
                "id_bloco_problema_relatado_escolido" => $idBlocoProblemaDiagnostico,
                "status_ordem_diagnostico" => $statusDiagnostico,
				"idtb_r_bloco_problema_funcionario_ordem" => $idBlocoFuncionarioOrdem,
                "id_tb_bloco_problemas_relatados" => $idBlocoProblemaView,
                "tipo_insercao" => $tipoInsercao,
                "cpf_funcionario" => $cpfFuncionario,
                "id_ordens_funcionario" => $idOrdemFuncionarioView,
                "status" => $statusBlocoOrdemFuncionario,
                "status_insercao_diagnostico" => $statusInsercaoDiagnostico,
                "status_insercao_passos_diagnostico" => $statusInsercaoPassos,
                "status_insercao_passos_ordens" => $statusInsercaoOrdens
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
	