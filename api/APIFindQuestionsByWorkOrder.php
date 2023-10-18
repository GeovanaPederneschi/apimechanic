<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnect.php');

    mysqli_set_charset($con, "utf8");

    $id_ordem = $_POST["id"];

    $statement = mysqli_prepare($con, 
    "SELECT * FROM view_perguntas_ordens WHERE id_ordens = ?");
    
    mysqli_stmt_bind_param($statement,"i",$id_ordem);

    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement,
						    $idOrdem,
						    $nomeOrdem,
						    $pergunta
                        ); 
 

    if (mysqli_stmt_num_rows($statement) > 0) {

        while (mysqli_stmt_fetch($statement)) {

            array_push($response, array(
                "id_ordens" => $idOrdem,
				"nome_ordens" => $nomeOrdem,
				"pergunta_servicos" => $pergunta
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
	