<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

// Verifique se os dados foram decodificados corretamente
if ($data === null) {
    echo json_encode(array('status' => 'error', 'message' => 'Dados inválidos'));
    exit;
}

// Prepare o array para armazenar os pontos de acesso
$access_points = array();
if (isset($data['access_points']) && is_array($data['access_points'])) {
    foreach ($data['access_points'] as $point) {
        if (isset($point['ssid']) && isset($point['rssi'])) {
            $access_points[] = array('name' => $point['ssid'], 'rssi' => $point['rssi']);
        }
    }
}

// Prepare a resposta
$response = array(
    'status' => 'success',
    'access_points' => $access_points
);

// Tente salvar os dados em um arquivo JSON
$filename = 'position.json';
if (file_put_contents($filename, json_encode($response)) === false) {
    echo json_encode(array('status' => 'error', 'message' => 'Não foi possível salvar o arquivo'));
    exit;
}

// Retorne a resposta
echo json_encode($response);
?>
