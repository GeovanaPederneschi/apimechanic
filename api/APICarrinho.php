<?php
header('Content-Type: application/json');

// Posições dos pontos de acesso (APs) na API
$accessPoints = array(
    'AP1' => array('x' => 4.29, 'y' => 0),
    'AP2' => array('x' => 6.09, 'y' => 2.35),
    'AP3' => array('x' => 0, 'y' => 2.85)
);

// Função para converter RSSI para distância
function rssiToDistance($rssi, $rssiRef, $n) {
    return pow(10, ($rssiRef - $rssi) / (10 * $n));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (isset($data['access_points']) && count($data['access_points']) == 3) {
        // Pega os dados dos três pontos de acesso
        $ap1 = $data['access_points'][0];
        $ap2 = $data['access_points'][1];
        $ap3 = $data['access_points'][2];

        // Converte RSSI para distâncias usando os valores de referência específicos
        $d1 = rssiToDistance($ap1['rssi'], 50, 3);     // AP1: ref = 50, n = 3
        $d2 = rssiToDistance($ap2['rssi'], 47, 3);     // AP2: ref = 47, n = 3
        $d3 = rssiToDistance($ap3['rssi'], 47, 3.5);   // AP3: ref = 47, n = 3.5

        // Obtém as posições dos APs
        $ap1_pos = $accessPoints['AP1'];
        $ap2_pos = $accessPoints['AP2'];
        $ap3_pos = $accessPoints['AP3'];

        // Cálculo da posição usando trilateração
        $A = 2 * ($ap2_pos['x'] - $ap1_pos['x']);
        $B = 2 * ($ap2_pos['y'] - $ap1_pos['y']);
        $C = pow($d1, 2) - pow($d2, 2) - pow($ap1_pos['x'], 2) + pow($ap2_pos['x'], 2) - pow($ap1_pos['y'], 2) + pow($ap2_pos['y'], 2);
        $D = 2 * ($ap3_pos['x'] - $ap2_pos['x']);
        $E = 2 * ($ap3_pos['y'] - $ap2_pos['y']);
        $F = pow($d2, 2) - pow($d3, 2) - pow($ap2_pos['x'], 2) + pow($ap3_pos['x'], 2) - pow($ap2_pos['y'], 2) + pow($ap3_pos['y'], 2);

        // Ajuste nas fórmulas para evitar divisões por zero ou resultados inconsistentes
        if (($E * $A - $B * $D) != 0 && ($B * $D - $A * $E) != 0) {
            // Resolve para X e Y
            $x = ($C * $E - $F * $B) / ($E * $A - $B * $D);
            $y = ($C * $D - $A * $F) / ($B * $D - $A * $E);
        } else {
            // Caso ocorra algum problema de divisão por zero
            $x = 0;
            $y = 0;
        }

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
        echo json_encode(array('status' => 'error', 'message' => 'Dados inválidos'));
    }
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Método não suportado'));
}
?>
