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
    "SELECT * from view_juridico_cliente WHERE id_tb_cliente_juridico = ?");
    mysqli_stmt_bind_param($statement,"i",$id);

    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement,
						    $id,
						    $dataCadastro,
						    $tipoCliente,
                            $cnpj,
						    $razaoSocial,
						    $nomeFantasia,
                            $telefone1,
                            $telefone2,
                            $obs,
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
				"cnpj" => $cnpj,
				"razao_social" => $razaoSocial,
				"nome_fantasia" => $nomeFantasia,
                "telefone1" => $telefone1,
                "telefone2" => $telefone2,
                "obs_adicional" => $obs,
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
	