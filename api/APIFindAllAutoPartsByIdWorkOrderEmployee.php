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
    "SELECT * FROM view_ordem_funcionario_peca WHERE id_tb_ordens_funcionario = ?");
    mysqli_stmt_bind_param($statement,"i",$id);

    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement,
						    $idFuncionarioPeca,
                            $idOrdemFuncionario,
                            $quantidadePeca,
                            $statusPeca,
                            $datetimePedido,
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
                 "idtb_r_ordens_funcionario_peca" => $idFuncionarioPeca,
                 "id_tb_ordens_funcionario" => $idOrdemFuncionario,
                 "quantidade_peca" => $quantidadePeca,
                 "status_peca" => $statusPeca,
                 "datetime_pedido" => $datetimePedido,
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
	