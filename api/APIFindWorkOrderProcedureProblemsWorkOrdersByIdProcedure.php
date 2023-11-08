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
    "SELECT * FROM view_ordem_procedimento_ordens_cliente WHERE idtb_ordem_servico_procedimento = ?");
    mysqli_stmt_bind_param($statement,"i",$id);

    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement,
						    $idProcedimento,
                            $datetimeCadastroProcedimento,
                            $statusProcedimento,
						    $idUnidade,
                            $nomeUnidade,
                            $cepUnidade,
                            $ruaUnidade,
                            $bairroUnidade,
                            $ufUnidade,
                            $numeroUnidade,
                            $complementoUnidade,
                            $cidadeUnidade,
                            $idOrdem,
                            $statusOrdem,
                            $codOrdem,
                            $tipoOperacaoOrdem,
                            $nomeOrdem,
                            $tempoOrdem,
                            $modoAtribuicao,
                            $categoriaTipoOrdem,
                            $categoriaSecaoOrdem,
                            $placa,
                            $marca,
                            $cadastroVeiculo,
                            $modelo,
                            $chassi,
                            $ano,
                            $cor,
                            $tracao,
                            $combustivel,
                            $estadoVeiculo,
                            $cidadeVeiculo,
                            $numeroFrota,
                            $cambio,
                            $tipoVeiculo,
                            $idCliente,
                            $cadastroCliente,
                            $identificacao,
                            $nomeCliente,
                            $telefone1,
                            $telefone2,
                            $idEndereco,
                            $cepCliente,
                            $ruaCliente,
                            $bairroCliente,
                            $ufCliente,
                            $numeroCliente,
                            $complementoCliente,
                            $cidadeCliente
                        ); 
 

    if (mysqli_stmt_num_rows($statement) > 0) {

        while (mysqli_stmt_fetch($statement)) {

            array_push($response, array(
                "idtb_ordem_servico_procedimento" => $idProcedimento,
                "datetime_cadastro_procedimento" => $datetimeCadastroProcedimento,
                "status_andamento" => $statusProcedimento,
                "id_tb_unidade" => $idUnidade,
                "nome_unidade" => $nomeUnidade,
                "cep_unidade" => $cepUnidade,
                "rua_unidade" => $ruaUnidade,
                "bairro_unidade" => $bairroUnidade,
                "uf_unidade" => $ufUnidade,
                "numero_unidade" => $numeroUnidade,
                "complemento_unidade" => $complementoUnidade,
                "cidade_unidade" => $cidadeUnidade,
                "id_tb_enum_ordens" => $idOrdem,
                "status_andamento_ordem" => $statusOrdem,
                "cod_tsv" => $codOrdem,
                "tipo_operacao" => $tipoOperacaoOrdem,
                "nome_ordens" => $nomeOrdem,
                "tempo_padrao" => $tempoOrdem,
                "modo_atribuicao" => $modoAtribuicao,
                "categoria_ordem" => $categoriaTipoOrdem,
                "categoria_seccao" => $categoriaSecaoOrdem,
                "placa_tb_veiculo" => $placa,
                "marca" => $marca,
				"cadastro_datetime" => $cadastro_datatimeVeiculo,
                "modelo" => $modelo,
                "chassi" => $chassi,
                "ano_fabricacao" => $ano,
                "cor" => $cor,
                "combustivel" => $combustivel,
                "tracao" => $tracao,
                "estado_veiculo" => $estadoVeiculo,
                "cidade_veiculo" => $cidadeVeiculo,
                "numero_frota" => $numeroFrota,
                "cambio" => $cambio,
                "tipo_veiculo" => $tipoVeiculo,
                "idtb_cliente" => $idCliente,
				"cadastro_datetime_cliente" => $cadastroCliente,
				"tipo_cliente" => $tipoCliente,
				"identificacao" => $identificacao,
                "nome_cliente" => $nomeCliente,
                "telefone1" => $telefone1,
                "telefone2" => $telefone2,
                "idtb_endereco" => $idEndereco,
                "cep_cliente" => $cepCliente,
                "rua_cliente" => $ruaCliente,
                "bairro_cliente" => $bairroCliente,
                "uf_cliente" => $ufCliente,
                "numero_cliente" => $numeroCliente,
                "complemento_cliente" => $complementoCliente,
                "cidade_cliente" => $cidadeCliente
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
	