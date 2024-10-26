<?php
header('Content-Type: application/json');

// Posições dos pontos de acesso (APs)
$accessPoints = array(
    'AP1' => array('x' => 3.36, 'y' => 0),       // Coordenadas em metros
    'AP2' => array('x' => 0, 'y' => 0),
    'AP3' => array('x' => 3.36, 'y' => 8.46)
);

// Array para armazenar mensagens de depuração
$debugMessages = array();

function rssiToDistanceTest($rssi, $apData) {
    // Dados do ponto de acesso
    $distances = [1, 2]; // Distâncias em metros
    $rssis = $apData; // Recebe os RSSIs do ponto de acesso

    // Se o RSSI medido é maior que -15, calcula distância < 1 metro
    if ($rssi > $rssis[0]) {
        $d1 = $distances[0]; // 1 metro
        $rssi1 = $rssis[0]; // -15
        // Interpolação linear
        $distance = $d1 * pow(10, ($rssi1 - $rssi) / 10); // Ajuste na fórmula para menos de 1 metro
        return $distance; // Retorna a distância calculada
    }
    
    // Se o RSSI medido é menor que -15 e maior que -40, calcula entre 1 e 2 metros
    if ($rssi <= $rssis[0] && $rssi > $rssis[1]) {
        // Regra de três para calcular a distância
        $d1 = $distances[0]; // 1 metro
        $d2 = $distances[1]; // 2 metros
        $rssi1 = $rssis[0]; // -15
        $rssi2 = $rssis[1]; // -40

        // Interpolação linear
        $distance = $d1 + (($d2 - $d1) * ($rssi - $rssi1) / ($rssi2 - $rssi1));
        return $distance; // Retorna a distância calculada
    }
    
    // Se o RSSI medido é menor que -40, retorna uma distância > 2 metros
    if ($rssi <= $rssis[1]) {
        return 2 + (abs($rssi - $rssis[1]) / 10); // Distância aproximada para > 2 metros
    }

    return -1; // Retorna -1 se não encontrar um intervalo válido
}

// Função para converter RSSI para distância
function rssiToDistance($rssi, $rssiRef, $n) {
    global $debugMessages;
    //return pow(10, ($rssiRef - $rssi) / 10*$n);
    return $rssi/$rssiRef;
    $debugMessages[] = "RSSI: $rssi -> Distância calculada: $distance metros"; // Armazena a mensagem de depuração
    return $distance;
}

// Função para limitar o resultado para evitar valores extremos
function limitValue($value, $min, $max) {
    return max($min, min($max, $value));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (isset($data['access_points']) && count($data['access_points']) == 3) {
        // Pega os dados dos três pontos de acesso
        $ap1 = $data['access_points'][0];
        $ap2 = $data['access_points'][1];
        $ap3 = $data['access_points'][2];

        // Converte RSSI para distâncias
        /* $d1 = rssiToDistance($ap1['rssi'], -15, 2.5);
        $d2 = rssiToDistance($ap2['rssi'], -35, 2.5);
        $d3 = rssiToDistance($ap3['rssi'], -22, 3.5);
 */
    $d1 = rssiToDistanceTest($ap1['rssi'], [-25, -30]);
    $d2 = rssiToDistanceTest($ap2['rssi'], [-35, -49]);
    $d3 = rssiToDistanceTest($ap3['rssi'], [-20, -30]);

        $debugMessages[] = "Distancias: d1=$d1, d2=$d2, d3=$d3";

        // Verifica se as distâncias são válidas
        if ($d1 <= 0 || $d2 <= 0 || $d3 <= 0) {
            echo json_encode(array('status' => 'error', 'message' => 'Valores de RSSI resultaram em distâncias inválidas.', 'debug' => $debugMessages));
            exit;
        }

        // Ajusta as distâncias para um valor máximo razoável
        $d1 = limitValue($d1, 0, 200);
        $d2 = limitValue($d2, 0, 200);
        $d3 = limitValue($d3, 0, 200);        

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

        // Verifica se o denominador é zero para evitar divisão por zero
        $denominatorX = ($E * $A - $B * $D);
        $denominatorY = ($B * $D - $A * $E);

        if ($denominatorX == 0 || $denominatorY == 0) {
            $debugMessages[] = 'Denominador zero detectado nas equações.';
            echo json_encode(array('status' => 'error', 'message' => 'Denominador zero detectado nas equações.', 'debug' => $debugMessages));
            exit;
        }

        // Resolve para X e Y
        $x = ($C * $E - $F * $B) / $denominatorX;
        $y = ($C * $D - $A * $F) / $denominatorY;

        // Limita os resultados para o intervalo esperado
        //$x = limitValue($x, 0, 10);
        //$y = limitValue($y, 0, 10);

        // Log de depuração para a posição calculada
        //$debugMessages[] = "Posição calculada: x=$x, y=$y";

        // Prepara os dados para enviar ao site
        $positionData = array(
            'x' => $x,
            'y' => $y
        );

        // Escreve os dados da posição em um arquivo JSON
        //file_put_contents('position.json', json_encode($positionData));

        // Dados a serem enviados
        $dataInsertion = array(
            'x' => $x,
            'y' => $y,
            'id_carrinho' => $data['carrinho_id'],
            'app'=> "Mechanic"
        );

        // URL da API onde os dados devem ser enviados
        $apiUrl = 'https://apimechanic.vercel.app/api/APIInsertLocation.php'; // Substitua pela URL correta da sua API

        // Inicializa a sessão cURL
        $ch = curl_init($apiUrl);

        // Configura as opções da requisição
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Retorna a resposta como string
        curl_setopt($ch, CURLOPT_POST, true); // Indica que a requisição é do tipo POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dataInsertion)); // Adiciona os dados ao corpo da requisição
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); // Define o tipo de conteúdo como JSON

        // Executa a requisição
        $response = curl_exec($ch);

        // Verifica se houve erro na requisição
        if (curl_errno($ch)) {
            $errorMessage = curl_error($ch);
            echo json_encode(array('status' => 'error', 'position' => $positionData, 'message' => $errorMessage, 'debug' => $debugMessages));
        } else {
           // Resposta ao ESP32 com logs de depuração
            echo json_encode(array('status' => 'success', 'position' => $positionData, 'debug' => $debugMessages, 'insercao' => $response, "ala"=>$dataInsertion));
        }

        // Fecha a sessão cURL
        curl_close($ch);
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Dados inválidos', 'debug' => $debugMessages));
    }
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Método não suportado', 'debug' => $debugMessages));
}
?>
