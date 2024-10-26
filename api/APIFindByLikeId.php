<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnectLazuli.php');

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    mysqli_set_charset($con, "utf8");

    $id = "%{$_POST['id']}%";

    $statement = mysqli_prepare($con, 
    "SELECT * from tb_ponto WHERE id LIKE ?");
    mysqli_stmt_bind_param($statement,"s",$id);

    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement,
						    $id,
						    $tipoPonto,
                            $x,
                            $y
                        ); 
 

    if (mysqli_stmt_num_rows($statement) > 0) {

        while (mysqli_stmt_fetch($statement)) {

            array_push($response, array(
                "id" => $id,
				"tipo_ponto" => $tipoPonto,
				"x_location" => $x,
                "y_location" +> $y
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
	