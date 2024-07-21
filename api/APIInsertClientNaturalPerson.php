<?php

header('Content-type: application/json');
ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] == "Mechanic") {

    require_once('dbConnect.php');
    mysqli_set_charset($con, "utf8");

    // Iniciar a transação
    mysqli_begin_transaction($con);

    try {
        // Primeira operação
        $tipo = $_POST["tipo"];
        $data = $_POST["data_registro"];

        $statement1 = mysqli_prepare($con, "INSERT INTO tb_cliente(data_cadastro, tipo_cliente) VALUES (?, ?)");
        mysqli_stmt_bind_param($statement1, 'ss', $data, $tipo);
        mysqli_stmt_execute($statement1);
        $id = mysqli_insert_id($con);
        $affect_nums1 = mysqli_stmt_affected_rows($statement1);

        // Segunda operação
        $cpf = $_POST["cpf"];
        $telefone2 = isset($_POST["telefone2"]) ? $_POST["telefone2"] : null;
        $email = $_POST["email"];
        $nome = $_POST["nome"];
        $telefone1 = $_POST["telefone1"];
        $rg = isset($_POST["rg"]) ? $_POST["rg"] : null;
        $aniversario = $_POST["aniversario"];

        $statement2 = mysqli_prepare($con, "INSERT INTO tb_cliente_fisico(cpf, id_tb_cliente_tb_cliente_fisico, nome, data_nascimento, rg, email, telefone1, telefone2) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($statement2, "sissssss", $cpf, $id, $nome, $aniversario, $rg, $email, $telefone1, $telefone2);
        mysqli_stmt_execute($statement2);
        $affect_nums2 = mysqli_stmt_affected_rows($statement2);

        // Confirmar a transação
        mysqli_commit($con);

        // Responder com sucesso
        $response["affect_nums"] = $affect_nums1 + $affect_nums2;
        $response["id"]=$id;
        $response["status"] = true;
    } catch (Exception $e) {
        // Reverter a transação em caso de erro
        mysqli_rollback($con);
        $response["status"] = false;
        $response["error"] = $e->getMessage();
    }

    echo json_encode($response);
    
} else {
    $response["status"] = false;
    $response["error"] = "Invalid request";
    echo json_encode($response);
}
?>
