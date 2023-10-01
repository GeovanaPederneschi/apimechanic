<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('../dbConnect.php');

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    mysqli_set_charset($con, "utf8");

    $cpf = $_POST['cpf'];

    $statement = mysqli_prepare($con, 
    "SELECT * from view_funcionario_mecanico WHERE cpf = ?");
    mysqli_stmt_bind_param($statement,"s",$cpf);

    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement,
                            $cpf,
                            $nome,
                            $tipoFuncionario,
                            $cadastroDatetime,
                            $senha,
                            $email,
                            $rg,
                            $telefone1,
                            $telefone2,
                            $status,
                            $nascimento,
                            $tipoMecanico
                        ); 
 

    if (mysqli_stmt_num_rows($statement) > 0) {

        while (mysqli_stmt_fetch($statement)) {

            array_push($response, array(
                "cpf" => $cpf,
				"nome" => $nome,
				"tipo_funcionario" => $tipoFuncionario,
				"cadastro_datetime" => $cadastroDatetime,
				"senha" => $senha,
				"email" => $email,
                "rg" => $rg,
                "telefone1" => $telefone1,
                "telefone2" => $telefone2,
                "status" => $status,
                "nascimento_date" => $nascimento,
                "tipo_mecanico" => $tipoMecanico
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
	