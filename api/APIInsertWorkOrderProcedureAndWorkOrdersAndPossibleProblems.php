<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('dbConnect.php');

    mysqli_set_charset($con, "utf8");

    mysqli_begin_transaction($con);

    
    try{
        
        $id_unidade = $_POST["id_unidade"];
        $id_cliente = $_POST["id_cliente"];
        $placa = $_POST["placa"];
        $cadastro_datetime = $_POST["cadastro_datetime"];
        $statusWorkOrderProcedure = $_POST["status"];

        $statement = mysqli_prepare($con, 
        "INSERT INTO `tb_ordem_servico_procedimento`(`id_tb_unidade`,`id_tb_cliente`,`placa_tb_veiculo`,`datetime_cadastro`,`status_andamento`)
        VALUES(?, ?, ?, ?, ?)");
        
        mysqli_stmt_bind_param($statement,"iisss",$id_unidade,$id_cliente,$placa,$cadastro_datetime,$statusWorkOrderProcedure);
        mysqli_stmt_execute($statement);
        $idWorkProcedure = mysqli_insert_id($con);

        $IDsWorkOrder = [];

        // WORK ORDERS

        if($_POST['ordens']!=null){

            $ordens_serviço = json_decode($_POST['ordens'],true);
            // [ [id_enum_ordem, status, tipo_atribuicao], [id_enum_ordem, status, tipo_atribuicao], ...]
            
            foreach($ordens_serviço as $key => $ordem){
                $statementWork = mysqli_prepare($con, 
                "INSERT INTO `tb_r_ordem_procedimento_enum_ordens`(`id_tb_ordem_servico_procedimento`,`id_tb_enum_ordens`,`status_andamento_ordem`,`tipo_atribuicao`)
                VALUES (?, ?, ?, ?)");

                $idOrdem = $ordem[0];
                $tatusWorkOrder = $ordem[1];
                $atribuicaoWorkOrder = $ordem[2];

                mysqli_stmt_bind_param($statementWork,"iiss",$idWorkProcedure, $idOrdem,$tatusWorkOrder,$atribuicaoWorkOrder);
                mysqli_stmt_execute($statementWork);
                array_push($IDsWorkOrder, mysqli_insert_id($con));
            }

        }


        // PROBLEMS

        if($_POST["problemas"]){
            $problems = json_decode($_POST['problemas'],true);
            // [id_problema, id_problema, ...]

            $IDsProblems = [];

            foreach($problems as $key => $idProblem){
                $statementProblem = mysqli_prepare($con, 
                "INSERT INTO `auto_mechanic`.`tb_r_ordem_procedimento_enum_problemas` (`id_tb_ordem_servico_procedimento`,`id_tb_enum_problema_relatados`)
                VALUES (?, ?)");
                
                mysqli_stmt_bind_param($statementProblem,"ii",$idWorkProcedure, $idProblem);
                mysqli_stmt_execute($statementProblem);
                array_push($IDsProblems, mysqli_insert_id($con));
            }

        }

        mysqli_commit($con);
        $response["status"] = true;
        $response["id_procedure"] = $idWorkProcedure;
        $response["ids_procedure_ordens"] = $IDsWorkOrder;

    }catch(Exception $e){
        mysqli_rollback($con);
        $response["status"] = false;
        $response["error"] = $e->getMessage();
    }

    echo json_encode($response);
    
} else {
    $response["status"] = false;
    $response["error"] = "Invalid request.";
    echo json_encode($response);
}
?>
	