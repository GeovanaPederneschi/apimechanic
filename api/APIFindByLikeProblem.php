<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnect.php');

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    mysqli_set_charset($con, "utf8");

    $problemaLike = "%{$_POST['problema']}%";
    $problema = $_POST['problema'];

    $statement = mysqli_prepare($con, 
    "SELECT * FROM tb_enum_problemas_relatados WHERE MATCH(problema_relatado) AGAINST (?)");
    mysqli_stmt_bind_param($statement,"s",$problema);

    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement,
						    $id,
						    $problemaRelatado,
                            $tipoInsercao
                        ); 
 

    if (mysqli_stmt_num_rows($statement) > 0) {

        while (mysqli_stmt_fetch($statement)) {

            array_push($response, array(
                "idtb_problemas_relatados" => $id,
				"problema_relatado" => $problemaRelatado,
                "tipo_insercao" => $tipoInsercao
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
	