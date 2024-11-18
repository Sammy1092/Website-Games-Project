<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/php_administrador/index.php';

    // Verifica se o usuário está logado
    if (isset($_SESSION['ID'])) {
        // Conexão com o banco de dados
        $conn = new mysqli('localhost', 'root', '', 'empresa');

        // Verifica a conexão
        if ($conn->connect_error) {
            die("Conexão falhou: " . $conn->connect_error);
        }

        // Busca o ID do usuário na sessão
        $idUsuario = $_SESSION['ID'];

        // Consulta SQL para buscar os dados do usuário
        $sql = "SELECT Nome, Usuário, Email, Senha FROM funcionario WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idUsuario);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verificar se encontrou o usuário
        if ($result->num_rows > 0) {
            $usuario = $result->fetch_assoc();
            $nome = htmlspecialchars($usuario['Nome']);
            $usuario_nome = htmlspecialchars($usuario['Usuário']);
            $email = htmlspecialchars($usuario['Email']);
            $senha = htmlspecialchars($usuario['Senha']);
        } else {
            echo "Usuário não encontrado.";
            header('Location: HomePage.php');
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Usuário não está logado.";
    }
    function detailsList()
    {
        $acList = [
            'Usuario' => ['id' => 'item_usuario'],
            'Autenticação' => ['id' => 'item_autenticacao'],
            'Compras' => ['id' => 'item_compras'],
        ];

        $html = '<ul class="list-account">';

        foreach ($acList as $key => $value) {
            $id = $value['id'];
            $html .= "<li class='menu_user-list'><a class='text_user' id='$id'>$key</a></li>";
        }

        $html .= '</ul>';

        return $html;
    }

    function custom_header(){
        $header_first = [
            'Home' => '../pages/HomePage.php',
            'Pagina exemplo' => '../pages/',
        ];
        
        $html = '<ul class="list_header">';
        foreach($header_first as $key => $value){
            $html .= "<li class='name'><a class='pages' href='$value'>$key</a></li>";
        }
        $html .= '</ul>';
        
        return $html;
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Page</title>
    <link rel="stylesheet" href="../css/AccountPage.css">
    <link rel="stylesheet" href="../css/homePage.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Agdasima:wght@400;700&family=Permanent+Marker&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</head>

<body>
    <header>
    <div class="header_home">
            <?php echo custom_header();?>
            <div class="container_button">
                <?php     
                    if($_SERVER['REQUEST_METHOD'] == 'GET'){
                        // Verifique se o usuário está logado
                        if (isset($_SESSION['Usuário'])) {
                            // Exibe o nome do usuário
                            echo "
                                <nav class='nav_login' id='navLogin'>
                                    " . htmlspecialchars($_SESSION['Usuário']) . "
                                    <div id='userMenu' class='user-menu'>
                                        <ul id='header_menu'>
                                            <li class='menu_list'><a href='../pages/AccountPage.php' class='item_menu'>Perfil</a></li>
                                            <li class='menu_list'><a href='../pages/AccountPage.php' class='item_menu'>Configurações</a></li>
                                            <li class='menu_list'><a href='logout.php' class='item_menu'>Logout</a></li>
                                        </ul>
                                    </div>
                                </nav>";
                        } else {
                            // Exibe os botões "Cadastrar" e "Login" se o usuário não estiver logado
                            echo '<nav>';
                            echo '<a id="registro" href="../pages/criarLogin.php">Cadastrar</a>';
                            echo '<a id="login" href="../pages/Login.php">Login</a>';
                            echo '</nav>';
                        }
                    }
                ?>
            </div>
        </div>
    </header>
    <div class="header-details_user">
        <div id="user">
            <img src="../image/profile-default-icon.png" width="100px" height="100px" alt="user_photo">
            <svg viewBox="0 0 24 24" width="24px" height="24px" fill="none" xmlns="http://www.w3.org/2000/svg" id="svg_edit">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <path d="M11 4H7.2C6.0799 4 5.51984 4 5.09202 4.21799C4.71569 4.40974 4.40973 4.7157 4.21799 5.09202C4 5.51985 4 6.0799 4 7.2V16.8C4 17.9201 4 18.4802 4.21799 18.908C4.40973 19.2843 4.71569 19.5903 5.09202 19.782C5.51984 20 6.0799 20 7.2 20H16.8C17.9201 20 18.4802 20 18.908 19.782C19.2843 19.5903 19.5903 19.2843 19.782 18.908C20 18.4802 20 17.9201 20 16.8V12.5M15.5 5.5L18.3284 8.32843M10.7627 10.2373L17.411 3.58902C18.192 2.80797 19.4584 2.80797 20.2394 3.58902C21.0205 4.37007 21.0205 5.6364 20.2394 6.41745L13.3774 13.2794C12.6158 14.0411 12.235 14.4219 11.8012 14.7247C11.4162 14.9936 11.0009 15.2162 10.564 15.3882C10.0717 15.582 9.54378 15.6885 8.48793 15.9016L8 16L8.04745 15.6678C8.21536 14.4925 8.29932 13.9048 8.49029 13.3561C8.65975 12.8692 8.89125 12.4063 9.17906 11.9786C9.50341 11.4966 9.92319 11.0768 10.7627 10.2373Z" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                </g>
            </svg>
        </div>
        <div id="user_list">
            <?php echo detailsList(); ?>
        </div>
        <div class="triangle"></div>
        <div class="form_account" id="user_form">
            <span id="user_h1">CONFIGURAÇÃO</span>
            <form method="post" action="index.php" class="info_account">
                <input type="text" placeholder="nome" name="inputName" id="inputName" class="input" value="<?php echo $nome ?>">
                <input type="text" placeholder="usuario" name="inputUserLog" id="inputUserLog" class="input" value="<?php echo $usuario_nome ?>">
                <svg viewBox="0 0 24 24" width="20px" height="20px" fill="none" xmlns="http://www.w3.org/2000/svg" class="svg_edit">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path d="M11 4H7.2C6.0799 4 5.51984 4 5.09202 4.21799C4.71569 4.40974 4.40973 4.7157 4.21799 5.09202C4 5.51985 4 6.0799 4 7.2V16.8C4 17.9201 4 18.4802 4.21799 18.908C4.40973 19.2843 4.71569 19.5903 5.09202 19.782C5.51984 20 6.0799 20 7.2 20H16.8C17.9201 20 18.4802 20 18.908 19.782C19.2843 19.5903 19.5903 19.2843 19.782 18.908C20 18.4802 20 17.9201 20 16.8V12.5M15.5 5.5L18.3284 8.32843M10.7627 10.2373L17.411 3.58902C18.192 2.80797 19.4584 2.80797 20.2394 3.58902C21.0205 4.37007 21.0205 5.6364 20.2394 6.41745L13.3774 13.2794C12.6158 14.0411 12.235 14.4219 11.8012 14.7247C11.4162 14.9936 11.0009 15.2162 10.564 15.3882C10.0717 15.582 9.54378 15.6885 8.48793 15.9016L8 16L8.04745 15.6678C8.21536 14.4925 8.29932 13.9048 8.49029 13.3561C8.65975 12.8692 8.89125 12.4063 9.17906 11.9786C9.50341 11.4966 9.92319 11.0768 10.7627 10.2373Z" stroke="#474747" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </g>
                </svg>
                <input type="text" placeholder="e-mail" name="inputEmailLog" id="inputEmailLog" class="input" value="<?php echo $email ?>">
                <svg viewBox="0 0 24 24" width="20px" height="20px" fill="none" xmlns="http://www.w3.org/2000/svg" class="svg_edit">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path d="M11 4H7.2C6.0799 4 5.51984 4 5.09202 4.21799C4.71569 4.40974 4.40973 4.7157 4.21799 5.09202C4 5.51985 4 6.0799 4 7.2V16.8C4 17.9201 4 18.4802 4.21799 18.908C4.40973 19.2843 4.71569 19.5903 5.09202 19.782C5.51984 20 6.0799 20 7.2 20H16.8C17.9201 20 18.4802 20 18.908 19.782C19.2843 19.5903 19.5903 19.2843 19.782 18.908C20 18.4802 20 17.9201 20 16.8V12.5M15.5 5.5L18.3284 8.32843M10.7627 10.2373L17.411 3.58902C18.192 2.80797 19.4584 2.80797 20.2394 3.58902C21.0205 4.37007 21.0205 5.6364 20.2394 6.41745L13.3774 13.2794C12.6158 14.0411 12.235 14.4219 11.8012 14.7247C11.4162 14.9936 11.0009 15.2162 10.564 15.3882C10.0717 15.582 9.54378 15.6885 8.48793 15.9016L8 16L8.04745 15.6678C8.21536 14.4925 8.29932 13.9048 8.49029 13.3561C8.65975 12.8692 8.89125 12.4063 9.17906 11.9786C9.50341 11.4966 9.92319 11.0768 10.7627 10.2373Z" stroke="#474747" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </g>
                </svg>
                <input type="text" placeholder="senha" name="inputPasswordLog" id="inputPasswordLog" class="input" value="<?php echo $senha ?>">
                <svg viewBox="0 0 24 24" width="20px" height="20px" fill="none" xmlns="http://www.w3.org/2000/svg" class="svg_edit">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path d="M11 4H7.2C6.0799 4 5.51984 4 5.09202 4.21799C4.71569 4.40974 4.40973 4.7157 4.21799 5.09202C4 5.51985 4 6.0799 4 7.2V16.8C4 17.9201 4 18.4802 4.21799 18.908C4.40973 19.2843 4.71569 19.5903 5.09202 19.782C5.51984 20 6.0799 20 7.2 20H16.8C17.9201 20 18.4802 20 18.908 19.782C19.2843 19.5903 19.5903 19.2843 19.782 18.908C20 18.4802 20 17.9201 20 16.8V12.5M15.5 5.5L18.3284 8.32843M10.7627 10.2373L17.411 3.58902C18.192 2.80797 19.4584 2.80797 20.2394 3.58902C21.0205 4.37007 21.0205 5.6364 20.2394 6.41745L13.3774 13.2794C12.6158 14.0411 12.235 14.4219 11.8012 14.7247C11.4162 14.9936 11.0009 15.2162 10.564 15.3882C10.0717 15.582 9.54378 15.6885 8.48793 15.9016L8 16L8.04745 15.6678C8.21536 14.4925 8.29932 13.9048 8.49029 13.3561C8.65975 12.8692 8.89125 12.4063 9.17906 11.9786C9.50341 11.4966 9.92319 11.0768 10.7627 10.2373Z" stroke="#474747" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </g>
                </svg>
            </form>
        </div>

        <div class="form_account" id="auth_form">
            <span id="user_h1">AUTENTICAÇÃO</span>
            <div class="auth_account">
                <input type="text" placeholder="senha de Autenticação" id="inputAuth" class="input">
                <a href="#" style="font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; 
                                    font-style:italic; 
                                    text-decoration:none; 
                                    color:#333; margin:0 10px;">Adquerir Autenticação</a>
            </div>
        </div>

        <div class="form_account" id="shop_form">
            <span id="user_h1">COMPRAS</span>
            <div class="shop_account">

            </div>
        </div>
    </div>

    <script type="module" src="../js/Account.js"></script>
    <script type="module" src="../js/homePage.js"></script>
</body>

</html>