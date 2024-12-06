<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/php_administrador/index.php';

$conn = new mysqli('localhost', 'root', '', 'empresa');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $usuario = mysqli_real_escape_string($conn, $_POST['inputUserLog']);
    $senha = mysqli_real_escape_string($conn, $_POST['inputPasswordLog']);

    // Verifica se o usuário existe no banco de dados
    $sqlVerifica = "SELECT * FROM funcionario WHERE Usuário = ?";
    $stmt = $conn->prepare($sqlVerifica);
    $stmt->bind_param('s', $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verifica se a senha está correta
        if (password_verify($senha, $user['Senha'])) {
            // Login bem-sucedido, registra o usuário na sessão
            $_SESSION['ID'] = $user['ID']; // Ou o ID que você usa na tabela
            $_SESSION['Usuário'] = $user['Usuário'];

            echo "Bem-vindo, " . $_SESSION['Usuário'] . "!";
            // Redireciona para uma página protegida, como dashboard.php
            header("Location: /php_administrador/assets/pages/HomePage.php");
            exit();
        } else {
            echo "Senha incorreta.";
        }
    } else {
        echo "Usuário não encontrado.";
    }

    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../image/login.ico" type="image/x-icon">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../css/loginPage.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Agdasima:wght@400;700&family=Permanent+Marker&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="form_user">
        <div class="dados-pessoais">
            <form action="Login.php" method="POST" class="container_formLogin">
                <div id="form_user">
                    <div class="h1">LOGIN</div>
                    <input type="text" placeholder="Login" name="inputUserLog" id="inputUserLog" required>
                    <input type="password" placeholder="Senha" name="inputPasswordLog" id="inputPasswordLog" required>

                    <button type="submit" class="botao">Enviar</button>
                </div>
            </form>
        </div>
    </div>
    <div id="loader">
        <div class="spinner-grow text-primary" id="load"></div>
    </div>

    <!-- Script jQuery para gerar e validar o checkbox -->
    <script type="text/javascript" src="../js/Login.js"></script>
</body>
</html>