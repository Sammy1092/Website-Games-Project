<?php

// Conexão com o banco de dados (ajuste conforme necessário)
require_once 'C:/xampp/htdocs/php_administrador/index.php';

// Lógica de registro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Inicializar variáveis de entrada
    $name = isset($_POST['inputName ']) ? mysqli_real_escape_string($conn, $_POST['inputName']) : null;
    $username = isset($_POST['Usuário']) ? mysqli_real_escape_string($conn, $_POST['inputUser']) : null;
    $email = isset($_POST['Email']) ? mysqli_real_escape_string($conn, $_POST['inputMail']) : null;
    $password = isset($_POST['Senha']) ? mysqli_real_escape_string($conn, $_POST['inputPassword']) : null;
    $confirmPassword = isset($_POST['ConfSenha']) ? mysqli_real_escape_string($conn, $_POST['inputPassword2']) : null;
   
    if (!empty($errors)) {
        echo "Os seguintes campos são obrigatórios: " . implode(', ', $errors);
    } elseif ($_POST['inputPassword'] !== $_POST['inputPassword2']) {
        echo "As senhas não coincidem.";
    } else {
        // Sanitizar e inicializar as variáveis
        $name = mysqli_real_escape_string($conn, $_POST['inputName']);
        $username = mysqli_real_escape_string($conn, $_POST['inputUser']);
        $email = mysqli_real_escape_string($conn, $_POST['inputMail']);
        $password = mysqli_real_escape_string($conn, $_POST['inputPassword']);

        // Verificar se o usuário já existe
        $query = "SELECT * FROM funcionario WHERE Email = '$email'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            echo "Usuário já registrado.";
        } else {
            // Inserir no banco
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $insertQuery = "INSERT INTO funcionario (Nome, Usuário, Email, Senha) VALUES ('$name', '$username', '$email', '$hashedPassword')";

            if (mysqli_query($conn, $insertQuery)) {
                echo "Usuário registrado com sucesso!";
            } else {
                echo "Erro ao registrar usuário: " . mysqli_error($conn);
            }
        }
    }
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
    <div class="form_user">
        <form action="Registro.php" method="post" id="formulario">
            <h1 class="h1">CADASTRO</h1>
            <nav class="formulario">
                <input type="text" name="inputName" placeholder="Nome" id="inputName">

                <input type="text" name="inputUser" placeholder="Usuário" id="inputUser">

                <input type="email" name="inputMail" placeholder="Email" id="inputMail">

                <input type="password" name="inputPassword" placeholder="Senha" id="inputPassword">

                <input type="password" name="inputPassword2" placeholder="Confirme a Senha" id="inputPassword2">

            </nav>
            <button type="submit" class="botao">Enviar</button>
            <span>Já é registrado? <a href="../pages/Login.php">Logar</a></span>
        </form>
    </div>
    <div id="loader">
        <div class="spinner-grow text-primary" id="load"></div>
    </div>

    <!-- Conteúdo da página -->
    <script type="module" src="../js/registerLogin.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(function() {
            var url_termos = "https://www.iubenda.com/termos-e-condicoes/76266882";
            var url_privacidade = "https://www.example.com/politica-de-privacidade";

            // HTML do checkbox com links
            var html = '<div class="termos-de-uso mt-3"> \
                            <div class="caixa-sombreada borda-principal"> \
                                <fieldset class="form-horizontal"> \
                                    <div class="form-check"> \
                                        <input id="marcar" class="form-check-input" type="checkbox"> \
                                        <label class="form-check-label" for="marcar"> \
                                            Li e concordo com os <a href="' + url_termos + '" target="_blank">termos de uso</a> \
                                            e <a href="' + url_privacidade + '" target="_blank">política de privacidade</a>. \
                                        </label> \
                                    </div> \
                                </fieldset> \
                            </div> \
                        </div>';
            
            // Insere o HTML após o botão Enviar
            $(".formulario").append(html);

            // Validação para garantir que o checkbox esteja marcado
            $(document).on("click", ".formulario .botao", function(e) {
                if (!$("#marcar").is(":checked")) {
                    alert("Você deve concordar com os termos e a política de privacidade.");
                    e.preventDefault(); // Impede o envio do formulário
                } else {
                    alert("Formulário enviado com sucesso!");
                }
            });
        });
    </script>

</body>

</html>
