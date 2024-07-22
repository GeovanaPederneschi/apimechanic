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
            $uploadFileDir = './images/step_diagnostic/';
            $imagePaths = array();

            foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
                // Inserir registro vazio na tabela de imagens para obter o ID
                $insertStmt = mysqli_prepare($con, 
                "INSERT INTO `auto_mechanic`.`tb_r_imagens_passo_diagnostico`(`id_passo_diagnostico`,`imagem_path`) VALUES (?, '')");
                mysqli_stmt_bind_param($insertStmt, "i", $id);

                if (mysqli_stmt_execute($insertStmt)) {
                    $imageId = mysqli_insert_id($con);

                    // Nomear e salvar o arquivo da imagem
                    $fileTmpPath = $_FILES['images']['tmp_name'][$key];
                    $fileName = $_FILES['images']['name'][$key];
                    $fileNameCmps = explode(".", $fileName);
                    $fileExtension = strtolower(end($fileNameCmps));
                    $newFileName = $imageId . "_image." . $fileExtension;
                    $dest_path = $uploadFileDir . $newFileName;

                    if (move_uploaded_file($fileTmpPath, $dest_path)) {
                        $imagePaths[] = $dest_path;

                        // Fazer update no banco de dados com o caminho do arquivo
                        $updateStmt = mysqli_prepare($con, 
                        "UPDATE `auto_mechanic`.`tb_r_imagens_passo_diagnostico`
                        SET `imagem_path` = ?
                        WHERE `idtb_r_imagens_passo_diagnostico` = ?");
                        mysqli_stmt_bind_param($updateStmt, 'si', $dest_path, $imageId);

                        if (!mysqli_stmt_execute($updateStmt)) {
                            throw new Exception("Failed to update image path for ID: " . $imageId);
                        }
                    } else {
                        throw new Exception("Failed to move uploaded file: " . $fileName);
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
?>
