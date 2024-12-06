<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/php_administrador/index.php';

// Configuração do banco de dados
$host = "localhost";
$user = "root";
$password = "";
$database = "gameshop";

$mysqli = new mysqli($host, $user, $password, $database);

if ($mysqli->connect_error) {
    die("Erro na conexão com o banco de dados: " . $mysqli->connect_error);
}

$msg = false;
if (isset($_FILES['arquivo'])) {
    // Obtenha a extensão e gere um novo nome único para o arquivo
    $extensao = strtolower(substr($_FILES['arquivo']['name'], -4));
    $novo_nome = md5(time()) . $extensao;
    $diretorio = 'upload/';

    // Mova o arquivo para o diretório de upload
    if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $diretorio . $novo_nome)) {
        // Prepara a consulta SQL usando statement
        $sql = "UPDATE games SET JogoP = ? WHERE id = 4";
        $stmt = $mysqli->prepare($sql);

        if ($stmt) {
            // Vincula os parâmetros
            $stmt->bind_param("s", $novo_nome);

            // Executa a consulta
            if ($stmt->execute()) {
                $msg = "Arquivo enviado com sucesso!";
            } else {
                $msg = "Erro ao atualizar o banco de dados.";
            }

            // Fecha o statement
            $stmt->close();
        } else {
            $msg = "Erro ao preparar a consulta SQL.";
        }
    } else {
        $msg = "Erro ao fazer upload do arquivo.";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <form action="gamePicture.php" method="post" enctype="multipart/form-data" >
        <input type="file" name="arquivo"/>
        <input type="submit" class="btn btn-secondary">
        <?php if($msg != false) echo "<p>$msg</p>"?>
    </form>
</body>
</html>