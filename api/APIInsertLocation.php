<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnectLazuli.php');

    mysqli_set_charset($con, "utf8");

    $id = $_POST["id_carrinho"];
    $x = $_POST["x"];
    $y = $_POST["y"];
    isset($_POST["id_demanda"]) ? $idDemanda = $_POST["id_demanda"] : $idDemanda = null;


    $statement = mysqli_prepare($con, 
    "INSERT INTO `tb_localizacao_carrinho` (`id_tb_carrinho`, `datatime_registro`, `x_localizacao`, `y_localizacao`, `id_demanda`) 
    VALUES (?, NOW(), ?, ?, ?)");
    mysqli_stmt_bind_param($statement,"iiii",$id, $x, $y, $idDemanda);

    mysqli_stmt_execute($statement);
  
       
        $response["affect_nums"] = mysqli_stmt_affected_rows($statement);
  
        $response["sucesso"] = true;
    

    echo json_encode($response);
    
} else {

    
    $response["sucesso"] = false;
    
    echo json_encode($response);
}
?>
	