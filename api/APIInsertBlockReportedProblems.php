<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnect.php');

    mysqli_set_charset($con, "utf8");

    $tipoInsercao = $_POST["tipo_insercao"];
    
    $statement = mysqli_prepare($con, 
    "INSERT INTO `auto_mechanic`.`tb_enum_bloco_problemas_relatados`
    (`tipo_insercao`)
    VALUES (?)");
    
    mysqli_stmt_bind_param($statement,"s",$tipoInsercao);

    mysqli_stmt_execute($statement);
  
       
        $response["affect_nums"] = mysqli_stmt_affected_rows($statement);
  
        $response["sucesso"] = true;
    

    echo json_encode($response);
    
} else {

    
    $response["sucesso"] = false;
    
    echo json_encode($response);
}
?>
	