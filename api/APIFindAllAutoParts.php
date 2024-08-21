<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnect.php');

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    mysqli_set_charset($con, "utf8");

    $statement = mysqli_prepare($con, 
    "SELECT * FROM auto_mechanic.view_peca_cod_servico");

    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement,
						    $idServicoPeça,
                            $idOrdem,
                            $quantidadePeça,
                            $modeloVeiculo,
                            $idPeça,
                            $nomePeça,
                            $nomeTecnicoPeça,
                            $outroNomePeça,
                            $imagemPeça,
                            $categoriaPeça,
                            $subcategoriaPeça,
                            $observaçãoPeça,
                            $codVolvo,
                            $codOutro
                        ); 
 

    if (mysqli_stmt_num_rows($statement) > 0) {

        while (mysqli_stmt_fetch($statement)) {

            array_push($response, array(
                 "idtb_enum_servico_pecas" => $idServicoPeça,
                 "id_tb_enum_ordens" => $idOrdem,
                 "quantidade_pecas" => $quantidadePeça,
                 "modelo_veiculo" => $modeloVeiculo,
                 "idtb_enum_pecas" => $idPeça,
                 "nome_pecas" => $nomePeça,
                 "nome_tecnico_pecas" => $nomeTecnicoPeça,
                 "outros_nomes_pecas" => $outroNomePeça,
                 "imagem_pecas" => $imagemPeça,
                 "categoria_pecas" => $categoriaPeça,
                 "subcategoria_pecas" => $subcategoriaPeça,
                 "observacao_peca" => $observaçãoPeça,
                 "cod_volvo" => $codVolvo,
                 "cod_outro" => $codOutro
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
    
    echo json_encode($response);
}
?>
	