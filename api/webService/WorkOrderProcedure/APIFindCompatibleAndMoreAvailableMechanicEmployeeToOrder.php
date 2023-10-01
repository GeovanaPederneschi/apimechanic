<?php

header('Content-type: application/json');

ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] = "Mechanic") {

    require_once('../dbConnect.php');

    mysqli_set_charset($con, "utf8");

    $tipos_mecanicos = $_POST["tipos_mecanicos"];
    $tipos_mecanicosArray = explode(";",$tipos_mecanicos);

    $tipos = "s";
    $where = "WHERE tipo_mecanico LIKE ?";
    for ($i=1; $i < count($tipos_mecanicosArray); $i++) { 
        $tipos .= "s";
        $where .= " OR tipo_mecanico LIKE ?";
    }

    for ($i=0; $i < count($tipos_mecanicosArray); $i++) {
        $tipos_mecanicosArray[$i] = substr_replace($tipos_mecanicosArray[$i],"%",0,0);
        $tipos_mecanicosArray[$i] = substr_replace($tipos_mecanicosArray[$i],"%",strlen($tipos_mecanicosArray[$i]),0);
    }


    $string = "SELECT cpf_tb_funcionario, tipo_mecanico, COUNT(cpf_tb_funcionario) as quantidade_ordem,
     SUM(tempo_padrao) AS tempo_total FROM view_outer_ordem_funcionario_dados
    $where AND status_atribuicao_valida = 'VALID'
    GROUP BY cpf_tb_funcionario
    HAVING   COUNT(cpf_tb_funcionario) >= 1
    ORDER BY tempo_total LIMIT 1";

    $statement = mysqli_prepare($con, $string);

    mysqli_stmt_bind_param($statement,$tipos,...$tipos_mecanicosArray);

    mysqli_stmt_execute($statement);

    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement,
						    $cpf,
                            $tipoMecanico,
                            $quantidadeOrdem,
                            $tempoTotal
                        ); 
 

    if (mysqli_stmt_num_rows($statement) > 0) {

        while (mysqli_stmt_fetch($statement)) {

            array_push($response, array(
                    "cpf_tb_funcionrios" => $cpf,
                    "tipo_mecanico" => $tipoMecanico,
                    "quantidade_ordem" => $quantidadeOrdem,
                    "tempo_total" => $tempoTotal
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
    $response["erro"] = "Method Error or App Denied";
    
    echo json_encode($response);
}
?>
	
	