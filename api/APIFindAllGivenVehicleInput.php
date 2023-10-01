<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnect.php');

    mysqli_set_charset($con, "utf8");

    $statement = mysqli_prepare($con, 
    "SELECT * FROM tb_enum_dado_veiculo_entrada");

    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement,
						    $id,
						    $nome,
						    $enum,
						    $obs
                        ); 
 

    if (mysqli_stmt_num_rows($statement) > 0) {

        while (mysqli_stmt_fetch($statement)) {

            array_push($response, array(
                "idtb_enum_dado_veiculo_entrada" => $id,
				"nome" => $nome,
				"enum_resposta" => $enum,
				"observacao" => $obs
                )
            );
        }
        
          
          
    } else {
    
           $response["sucesso"] = false;
           $response["error"]="no queries";
    }

    echo json_encode($response);
    
} else {

    
    $response["sucesso"] = false;
    
    echo json_encode($response);
}
?>
	