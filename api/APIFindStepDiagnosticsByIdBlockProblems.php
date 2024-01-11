<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnect.php');

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    mysqli_set_charset($con, "utf8");

    $idBlocoProblema = $_POST['id'];

    $statement = mysqli_prepare($con,
    "SELECT * FROM view_bloco_problemas_passos_diagnostico WHERE id_tb_enum_bloco_problemas_relatados = ?");
    mysqli_stmt_bind_param($statement,"i",$idBlocoProblema);

    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement,
						    $id,
                            $idBlocoProblema,
                            $idPasso,
                            $passo,
                            $categoriaPasso
                        ); 
 

    if (mysqli_stmt_num_rows($statement) > 0) {

        while (mysqli_stmt_fetch($statement)) {

            array_push($response, array(
                "idtb_r_enum_bloco_problemas_tb_passos_diagnostico" => $id,
                "id_tb_enum_bloco_problemas_relatados" => $idBlocoProblema,
                "id_tb_enum_passos_diagnostico" => $idPasso,
				"nome_passo" => $passo,
                "categoria_passos_diagnostico" => $categoriaPasso
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
	