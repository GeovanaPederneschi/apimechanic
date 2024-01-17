<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnect.php');

    mysqli_set_charset($con, "utf8");

    $stringIDs = $_POST["IDs"];
    $diagnosticosIds = explode(";",$stringIDs);
    $diagnosticosIds2 = array_merge($diagnosticosIds,$diagnosticosIds);
    $tipos = "ii";
    $in = "?";
    for ($i=1; $i < count($diagnosticosIds); $i++) { 
        $tipos .= "ii";
        $in .= ", ?";
    }

    $string = "SELECT bp.idtb_r_bloco_problemas_tb_diagnostico, bp.id_tb_enum_bloco_problemas_relatados, bp.id_tb_enum_diagnostico,
    pr.nome_diagnostico, pr.categoria_diagnostico
        FROM tb_r_enum_bloco_problemas_tb_diagnostico bp
        JOIN tb_enum_diagnostico pr
        ON bp.id_tb_enum_diagnostico = pr.idtb_diagnostico
        WHERE id_tb_enum_bloco_problemas_relatados IN (
        SELECT id_tb_enum_bloco_problemas_relatados
        FROM tb_r_enum_bloco_problemas_tb_diagnostico
        WHERE id_tb_enum_diagnostico IN ($in)
        GROUP BY id_tb_enum_bloco_problemas_relatados
        HAVING COUNT(DISTINCT id_tb_enum_diagnostico) = 
        (SELECT COUNT(DISTINCT id_tb_enum_diagnostico) FROM tb_r_enum_bloco_problemas_tb_diagnostico WHERE id_tb_enum_diagnostico IN ($in))
        );";

    $statement = mysqli_prepare($con, $string);

    mysqli_stmt_bind_param($statement,$tipos,...$diagnosticosIds2);

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
    }else{
           $response["sucesso"] = false;
           $response["error"] = "No queries";
    }

    echo json_encode($response);
    
} else {

    
    $response["sucesso"] = false;
    $response["erro"] = "Method Error or App Denied";
    
    echo json_encode($response);
}
?>
	
	