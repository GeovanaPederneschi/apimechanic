<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

// Obter os dados do corpo da requisição (JSON)
$inputData = file_get_contents('php://input');

// Decodificar o JSON recebido
$data = json_decode($inputData, true);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $data['app'] = "Mechanic") {

    require_once('dbConnectLazuli.php');

    mysqli_set_charset($con, "utf8");

    $id = $data["id_carrinho"];
    $x = $data["x"];
    $y = $data["y"];
    isset($data["id_demanda"]) ? $idDemanda = $data["id_demanda"] : $idDemanda = null;


    $statement = mysqli_prepare($con, 
    "INSERT INTO `tb_localizacao_carrinho` (`id_tb_carrinho`, `datatime_registro`, `x_localizacao`, `y_localizacao`, `id_demanda`) 
    VALUES (?, NOW(), ?, ?, ?)");
    mysqli_stmt_bind_param($statement,"iddi",$id, $x, $y, $idDemanda);

    mysqli_stmt_execute($statement);
  
       
        $response["affect_nums"] = mysqli_stmt_affected_rows($statement);
  
        $response["sucesso"] = true;
    

    echo json_encode($response);
    
} else {

    
    $response["sucesso"] = false;
    
    echo json_encode($response);
}
?>
	