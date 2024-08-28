<?php
header('Content-Type: application/json');

// Posições dos pontos de acesso (APs) na API
$accessPoints = array(
    'AP1' => array('x' => 5, 'y' => 5),
    'AP2' => array('x' => 15, 'y' => 5),
    'AP3' => array('x' => 10, 'y' => 15)
);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recebe os dados JSON enviados pelo ESP32
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    // Verifica se os dados estão corretos
    if (isset($data['access_points']) && count($data['access_points']) == 3) {
        // Pega os dados dos três pontos de acesso mais próximos
        $ap1 = $data['access_points'][0];
        $ap2 = $data['access_points'][1];
        $ap3 = $data['access_points'][2];
        

        // Definindo variáveis com dados dos APs
        $ap1_pos = isset($accessPoints['AP1']) ? $accessPoints['AP1'] : ['x' => 0, 'y' => 0];
        $ap2_pos = isset($accessPoints['AP2']) ? $accessPoints['AP2'] : ['x' => 0, 'y' => 0];
        $ap3_pos = isset($accessPoints['AP3']) ? $accessPoints['AP3'] : ['x' => 0, 'y' => 0];

        // Realiza a triangulação usando as posições dos APs e os valores de RSSI
        // A triangulação exata deve ser implementada com base nos valores de RSSI
        // Aqui, um exemplo simples sem cálculo real
        $x = ($ap1_pos['x'] + $ap2_pos['x'] + $ap3_pos['x']) / 3;
        $y = ($ap1_pos['y'] + $ap2_pos['y'] + $ap3_pos['y']) / 3;

        // Prepara os dados para enviar ao site
        $positionData = array(
            'x' => $x,
            'y' => $y
        );

        // Escreve os dados da posição em um arquivo JSON para que o site possa acessar
        file_put_contents('position.json', json_encode($positionData));

        // Resposta ao ESP32
        echo json_encode(array('status' => 'success', 'position' => $positionData));
    } else {
        // Caso os dados não estejam corretos
        echo json_encode(array('status' => 'error', 'message' => 'Dados inválidos'));
    }
} else {
    // Resposta se o método não for POST
    echo json_encode(array('status' => 'error', 'message' => 'Método não suportado'));
}
