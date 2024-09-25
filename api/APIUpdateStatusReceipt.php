<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();
$response["sucesso"] = false; // Inicializa como false

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['app']) && $_POST['app'] == "Mechanic") {

    require_once('dbConnectLazuli.php');

    mysqli_set_charset($con, "utf8");

    // Obter os parâmetros da requisição
    $idDemanda = $_POST["id_demanda"];
    $status = $_POST["status"];
    $idPontoColeta = $_POST["id_coleta"];
    $idPontoEntrega = $_POST["id_entrega"];
    $idCarrinho = $_POST["id_carrinho"];
    $status_direction = $_POST["status_direction"];

    // Preparar e executar a atualização da demanda
    $statement = mysqli_prepare($con, 
    "UPDATE `deere_challenge`.`tb_demanda`
    SET
    `status_progresso` = ?,
    `datatime_finalizado` = NOW()
    WHERE `id` = ?");
    
    mysqli_stmt_bind_param($statement, "si", $status, $idDemanda);
    mysqli_stmt_execute($statement);

    // Verificar se a atualização foi bem-sucedida
    $response["affect_nums"] = mysqli_stmt_affected_rows($statement);

    if ($response["affect_nums"] > 0) {
        // Verificar se a demanda foi finalizada
        if ($status == 'DONE' && $status_direction == 'PEGANDO_PECA') {
            // Inserir nova demanda
            $insertQuery = "INSERT INTO tb_demanda (idCarrinho, idPontoColeta, idPontoEntrega, status_progresso, status_direction, datatime_cadastro)
                            VALUES (?, ?, ?, 'IN_PROGRESS', 'ENTREGANDO_PECA', NOW())";
            $stmt = mysqli_prepare($con, $insertQuery);
            mysqli_stmt_bind_param($stmt, "iii", $idCarrinho, $idPontoEntrega, $idPontoColeta);
            mysqli_stmt_execute($stmt);
            
            // Pegar o ID da nova demanda
            $new_demand_id = mysqli_insert_id($con);
        
            // Copiar as peças relacionadas para a nova demanda
            $copyQuery = "INSERT INTO tb_r_demanda_pecas (id_tb_demanda, id_tb_peca, quantidade)
                          SELECT ?, id_tb_peca, quantidade FROM view_demanda_peca_ponto WHERE id_tb_demanda = ?";
            $stmt = mysqli_prepare($con, $copyQuery);
            mysqli_stmt_bind_param($stmt, "ii", $new_demand_id, $idDemanda);
            mysqli_stmt_execute($stmt);
        }

        // Se todas as operações forem bem-sucedidas, define sucesso como true
        $response["sucesso"] = true;
        $response["affect_nums"] = 1;
    } else {
        $response["mensagem"] = "Nenhuma atualização realizada.";
    }

    echo json_encode($response);
    
} else {
    $response["mensagem"] = "Requisição inválida.";
    echo json_encode($response);
}
?>
