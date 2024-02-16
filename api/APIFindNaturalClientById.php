<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnect.php');

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    mysqli_set_charset($con, "utf8");

    $id = $_POST['id'];

    $statement = mysqli_prepare($con, 
    "SELECT * from view_fisico_cliente WHERE idtb_cliente LIKE ?");
    mysqli_stmt_bind_param($statement,"i",$id);

    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement,
						    $id,
						    $dataCadastro,
						    $tipoCliente,
						    $cpf,
						    $nome,
						    $dataNascimento,
                            $rg,
                            $email,
                            $telefone1,
                            $telefone2,
                            $idEndereco,
                            $cep,
                            $nomeEndereco,
                            $rua,
                            $bairro,
                            $uf,
                            $numero,
                            $complemento,
                            $cidade
                        ); 
 

    if (mysqli_stmt_num_rows($statement) > 0) {

        while (mysqli_stmt_fetch($statement)) {

            array_push($response, array(
                "idtb_cliente" => $id,
				"data_cadastro" => $dataCadastro,
				"tipo_cliente" => $tipoCliente,
				"cpf" => $cpf,
				"nome" => $nome,
				"data_nascimento" => $dataNascimento,
                "rg" => $rg,
                "email" => $email,
                "telefone1" => $telefone1,
                "telefone2" => $telefone2,
                "idtb_endereco" => $idEndereco,
                "cep" => $cep,
                "nome_endereco" => $nomeEndereco,
                "rua" => $rua,
                "bairro" => $bairro,
                "uf_estado" => $uf,
                "numero" => $numero,
                "complemento" => $complemento,
                "cidade" => $cidade
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
	