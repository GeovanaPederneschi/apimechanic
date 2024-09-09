<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnectLazuli.php');

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    mysqli_set_charset($con, "utf8");

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $statement = mysqli_prepare($con, 
    "SELECT * from tb_funcionario WHERE email_funcionario = ? AND senha_funcionario = ?");
    mysqli_stmt_bind_param($statement,"ss",$email,$senha);

    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement,
						    $cpf,
						    $senha,
                            $email,
                            $niver,
                            $nome,
                            $numero,
                            $tipo
                        ); 
 

    if (mysqli_stmt_num_rows($statement) > 0) {

        while (mysqli_stmt_fetch($statement)) {

            array_push($response, array(
                "cpf_funcionario " => $cpf,
				"senha_funcionario" => $senha,
                "email_funcionario" => $email,
                "aniversario_funcionario" => $niver,
                "nome_funcionario" => $nome,
                "numero_funcionario" => $numero,
                "tipo_funcionario" => $tipo
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
	