<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnect.php');

    mysqli_set_charset($con, "utf8");

    $ordem = $_POST["ordem"];
    $tipo_insercao = $_POST["tipo_insercao"];
    $catOrdem = $_POST["categoria_ordem"];
    $catSeccao = $_POST["categoria_seccao"];
    $tempo = $_POST["tempo_padrao"];
    $modo = $_POST["modo_atribuicao"];
    $tipoOpe = $_POST["tipo_operacao"];

    $statement = mysqli_prepare($con, 
    "INSERT INTO `auto_mechanic`.`tb_enum_ordens`(`cod_tsv`,`tipo_operacao`,`nome_ordens`,`tempo_padrao`,`modo_atribuicao`,`categoria_ordem`,`categoria_seccao`,`tipo_insercao`)
    VALUES
    (null, ?, ?, ?, ?, ?, ?, ?);
    ");

    mysqli_stmt_bind_param($statement, 'ssissss', $tipoOpe, $ordem, $tempo, $modo, $catOrdem, $catSeccao, $tipo_insercao);
    mysqli_stmt_execute($statement);

    $id = mysqli_insert_id($con);

    $response["id_ordens"] = $id;
    $response["affect_nums"] = mysqli_stmt_affected_rows($statement);

    echo json_encode($response);
    
} else {

    
    $response["sucesso"] = false;
    
    echo json_encode($response);
}
?>
	