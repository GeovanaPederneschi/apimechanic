<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('../dbConnect.php');

    mysqli_set_charset($con, "utf8");

    $id_procedimento = $_POST["id_procedimento"];
    $id_ordem = $_POST["id_ordem"];

    $statement = mysqli_prepare($con, 
    "SELECT idtb_r_ordem_procedimento_enum_ordens FROM tb_r_ordem_procedimento_enum_ordens 
    WHERE id_tb_ordem_servico_procedimento = ? AND id_tb_enum_ordens = ?");
    mysqli_stmt_bind_param($statement,"ii",$id_procedimento,$id_ordem);

    mysqli_stmt_execute($statement);

    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement,
						    $id
                        ); 
 

    if (mysqli_stmt_num_rows($statement) > 0) {

        while (mysqli_stmt_fetch($statement)) {

            array_push($response, array(
                "idtb_r_ordem_procedimento_enum_ordens" => $id
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
	