<?php

require_once 'C:/xampp/htdocs/php_administrador/index.php'; // Conexão ao banco de dados
// Verifique se o formulário foi enviado antes de acessar `$_POST`
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Verifique se os campos estão definidos e atribua valores seguros
    $inputUser = isset($_POST['inputUser']) ? mysqli_real_escape_string($conn, $_POST['inputUser']) : '';
    $inputMail = isset($_POST['inputMail']) ? mysqli_real_escape_string($conn, $_POST['inputMail']) : '';
    $inputPassword = isset($_POST['inputPassword']) ? mysqli_real_escape_string($conn, $_POST['inputPassword']) : '';
    $confSenha = isset($_POST['confSenha']) ? mysqli_real_escape_string($conn, $_POST['confSenha']) : '';

    // Verificação de senha
    if ($inputPassword !== $confSenha) {
        echo "As senhas não coincidem";
    }
    // Código adicional para registrar o usuário aqui...
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link rel="shortcut icon" href="../image/criarlog.ico" type="image/x-icon">

    <title>Crie seu Login</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/registerPage.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Agdasima:wght@400;700&family=Permanent+Marker&display=swap" rel="stylesheet">
</head>

<body> 
    <!-- <img src="../image/1338599.png" alt="" id="image"/>-->
    <div class="form_user">
        <img src="../image/1338599.png" alt="plano de fundo" width="1000px" height="500px" style="position:relative; z-index:1;" id="image"/>
        <form action="Registro.php" method="post" id="formulario" style="position:relative; z-index:2;">
            <div class="dados-pessoais">
                <h1 class="h1">CADASTRO</h1>
                <input type="text" name="inputName" placeholder="Nome" id="inputName">
                <input type="text" name="inputUser" placeholder="Usuário" id="inputUser">
                <input type="email" name="inputMail" placeholder="Email" id="inputMail">
                <input type="password" name="inputPassword" placeholder="Senha" id="inputPassword">
                <input type="password" name="inputPassword2" placeholder="Confirme a Senha" id="inputPassword2">
            </div>

            <!-- Botão de submissão do formulário -->
            <button type="button" class="botao">Enviar</button>
        </form>
    </div>
    <div id="loader">
        <div class="spinner-grow text-primary" id="load"></div>
    </div>

    <!-- Conteúdo da página -->
    <script type="module" src="../js/registerLogin.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>
