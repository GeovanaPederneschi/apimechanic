<?php

header('Content-type: application/json');
ini_set('default_charset', 'utf-8');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['app'] == "Mechanic") {
    require_once('dbConnect.php');
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    mysqli_set_charset($con, "utf8");

    mysqli_begin_transaction($con);

    try {
        $idOrdemDiagnostico = $_POST['id_ordem'];
        $idPasso = $_POST['id_passo'];
        $observacao = $_POST['obs'];

        $statement = mysqli_prepare($con,
        "INSERT INTO `tb_r_passo_ordem_diagnostico`(`id_tb_ordem_diagnostico`,`id_tb_passos_diagnostico`,`observacao_passo`)
        VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($statement, "iis", $idOrdemDiagnostico, $idPasso, $observacao);
        mysqli_stmt_execute($statement);
        $id = mysqli_insert_id($con);

        // Verificar se há imagens
        if (isset($_FILES['images']) && count($_FILES['images']['tmp_name']) > 0) {
            $imagePaths = array();
            
            $uploadPreset = 'ml_default'; // Substitua com o nome do seu preset de upload, se necessário
            $folderName = 'step_diagnostic'; // Nome da pasta onde as imagens serão salvas

            foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
                // Inserir registro vazio na tabela de imagens para obter o ID
                $insertStmt = mysqli_prepare($con, 
                "INSERT INTO `auto_mechanic`.`tb_r_imagens_passo_diagnostico`(`id_passo_diagnostico`,`imagem_path`) VALUES (?, '')");
                mysqli_stmt_bind_param($insertStmt, "i", $id);

                if (mysqli_stmt_execute($insertStmt)) {
                    $imageId = mysqli_insert_id($con);

                    // Configurar o cURL para upload
                    $fileTmpPath = $_FILES['images']['tmp_name'][$key];
                    $fileData = array(
                        'file' => new CURLFile($fileTmpPath),
                        'upload_preset' => $uploadPreset,
                        'folder' => $folderName // Especifica a pasta onde a imagem será salva
                    );

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $uploadUrl);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $fileData);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);

                    if (curl_errno($ch)) {
                        throw new Exception("cURL error: " . curl_error($ch));
                    }

                    curl_close($ch);

                    $responseData = json_decode($response, true);

                    if (isset($responseData['secure_url'])) {
                        $imageUrl = $responseData['secure_url'];

                        // Fazer update no banco de dados com o URL da imagem
                        $updateStmt = mysqli_prepare($con, 
                        "UPDATE `auto_mechanic`.`tb_r_imagens_passo_diagnostico`
                        SET `imagem_path` = ?
                        WHERE `idtb_r_imagens_passo_diagnostico` = ?");
                        mysqli_stmt_bind_param($updateStmt, 'si', $imageUrl, $imageId);

                        if (!mysqli_stmt_execute($updateStmt)) {
                            throw new Exception("Failed to update image path for ID: " . $imageId);
                        }

                        $imagePaths[] = $imageUrl;
                    } else {
                        throw new Exception("Failed to upload image to Cloudinary: " . $response);
                    }
                } else {
                    throw new Exception("Failed to insert initial image record.");
                }
            }

            $response["image_paths"] = $imagePaths;
        }

        mysqli_commit($con);
        $response["status"] = true;
        $response["id_passo"] = $id;
    } catch (Exception $e) {
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
