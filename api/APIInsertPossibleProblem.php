<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnect.php');

    mysqli_set_charset($con, "utf8");

    $problema = $_POST["problema"];
    $tipo_insercao = $_POST["tipo_insercao"];

    $statement = mysqli_prepare($con, 
    "INSERT INTO `auto_mechanic`.`tb_enum_problemas_relatados`(`problema_relatado`,`tipo_insercao`)
    VALUES( ?, ?);
    SELECT LAST_INSERT_ID()");

    mysqli_stmt_bind_param($statement,'ss',$problema,$tipo_insercao);

    mysqli_stmt_execute($statement);

    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement,
						    $id
                        ); 
  
                        if (mysqli_stmt_num_rows($statement) > 0) {

                            while (mysqli_stmt_fetch($statement)) {
                    
                                array_push($response, array(
                                    "idtb_problemas_relatados" => $id,
                                    "affect_nums" => mysqli_stmt_affected_rows($statement)
                                    )
                                );
                            }
                            
                              
                              
                        } else {
                        
                               $response["sucesso"] = false;
                               $response["affect_nums"] = mysqli_stmt_affected_rows($statement);
                        }

    echo json_encode($response);
    
} else {

    
    $response["sucesso"] = false;
    
    echo json_encode($response);
}
?>
	