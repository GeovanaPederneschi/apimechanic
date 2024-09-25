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
    "SELECT * from view_funcionario_carrinho WHERE email_func = ? AND senha_func = ?");
    mysqli_stmt_bind_param($statement,"ss",$email,$senha);

    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement,
                            $id,
                            $nome,
                            $dataNascimento,
						    $cpf,
                            $email,
                            $senha,
                            $idFilial,
                            $dataAdimissão,
                            $telefone,
                            $endereço,
                            $idCargo,
                            $tipoFuncionario,
                            $idCarrinho,
                            $numIdent
                        ); 
 

    if (mysqli_stmt_num_rows($statement) > 0) {

        while (mysqli_stmt_fetch($statement)) {

            array_push($response, array(
                "id" => $id,
                "nome_func" => $nome,
                "data_nascimento" => $dataNascimento,
                "CPF" => $cpf,
				"senha_func" => $senha,
                "email_func" => $email,
                "filial_id" => $idFilial,
                "data_admissao" => $dataAdimissão,
                "telefone" => $telefone,
                "endereco" => $endereço,
                "cargo_id" => $idCargo,
                "tipo_funcionario" => $tipoFuncionario,
                "id_carrinho" => $idCarrinho,
                "num_ident" => $numIdent
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
	