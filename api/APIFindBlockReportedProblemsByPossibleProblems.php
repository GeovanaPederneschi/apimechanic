<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnect.php');

    mysqli_set_charset($con, "utf8");

    $stringIDs = $_POST["IDs"];
    $problemasIDs = explode(";",$stringIDs);
    $problemasIDs2 = array_merge($problemasIDs,$problemasIDs);
    $tipos = "ii";
    $in = "?";
    for ($i=1; $i < count($problemasIDs); $i++) { 
        $tipos .= "ii";
        $in .= ", ?";
    }

    $string = "SELECT idtb_r_enum_bloco_tb_problemas_relatados,
    id_tb_enum_bloco_problemas_relatados,
    id_tb_enum_problemas_relatados
    FROM tb_r_enum_bloco_tb_problemas_relatados
    WHERE id_tb_enum_bloco_problemas_relatados IN (
    SELECT id_tb_enum_bloco_problemas_relatados
    FROM tb_r_enum_bloco_tb_problemas_relatados
    WHERE id_tb_enum_problemas_relatados IN ($in)
    GROUP BY id_tb_enum_bloco_problemas_relatados
    HAVING COUNT(DISTINCT id_tb_enum_problemas_relatados) = (SELECT COUNT(DISTINCT id_tb_enum_problemas_relatados) FROM tb_r_enum_bloco_tb_problemas_relatados WHERE id_tb_enum_problemas_relatados IN ($in))
    );";

    $statement = mysqli_prepare($con, $string);

    mysqli_stmt_bind_param($statement,$tipos,...$problemasIDs2);

    mysqli_stmt_execute($statement);

    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement,
						    $id,
                            $idBloco,
                            $idProblema,
                            $problema
                        ); 
 

    if (mysqli_stmt_num_rows($statement) > 0) {

        while (mysqli_stmt_fetch($statement)) {

            array_push($response, array(
                    "idtb_r_enum_bloco_tb_problemas_relatados" => $id,
                    "id_tb_enum_bloco_problemas_relatados" => $idBloco,
                    "id_tb_enum_problemas_relatados" => $idProblema,
                    "problema_relatado" => $problema
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
	
	