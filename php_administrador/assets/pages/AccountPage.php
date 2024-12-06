<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/php_administrador/index.php';

    // Verifica se há um arquivo enviado
    if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] == UPLOAD_ERR_OK) {
        $userId = $_SESSION['ID']; // Supondo que o ID do usuário esteja na sessão
        $fileTmpPath = $_FILES['arquivo']['tmp_name'];
        $fileName = $_FILES['arquivo']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    
        // Valida extensões permitidas
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($fileExtension, $allowedExtensions)) {
            echo json_encode(['success' => false, 'message' => 'Extensão inválida.']);
            exit;
        }
    
        // Gera um nome único para o arquivo
        $newFileName = uniqid('profile_') . '.' . $fileExtension;
        $uploadDir = 'profile/';
        $destPath = $uploadDir . $newFileName;
    
        // Move o arquivo para o diretório
        if (move_uploaded_file($fileTmpPath, $destPath)) {
            // Atualiza o banco de dados com o novo nome da imagem
            $mysqli = new mysqli('localhost', 'root', '', 'empresa');
            $stmt = $mysqli->prepare("UPDATE funcionario SET Foto = ? WHERE ID = ?");
            $stmt->bind_param('si', $newFileName, $userId);
    
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'newFileName' => $newFileName]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Erro ao atualizar o banco de dados.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao salvar o arquivo.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Nenhuma imagem enviada.']);
    }

    // Verifica se o usuário está logado
    if (isset($_SESSION['ID'])) {
        $conn = new mysqli('localhost', 'root', '', 'empresa');
    
        if ($conn->connect_error) {
            die("Conexão falhou: " . $conn->connect_error);
        }
    
        $idUsuario = $_SESSION['ID'];
        $sql = "SELECT Nome, Usuário, Email, Senha FROM funcionario WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idUsuario);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $usuario = $result->fetch_assoc();
            $nome = htmlspecialchars($usuario['Nome']);
            $usuario_nome = htmlspecialchars($usuario['Usuário']);
            $email = htmlspecialchars($usuario['Email']);
            $senha = htmlspecialchars($usuario['Senha']);
        } else {
            echo "Usuário não encontrado.";
            header('Location: HomePage.php');
            exit;
        }
    
        $stmt->close();
        $conn->close();
    } else {
        echo "Usuário não está logado.";
        header('Location: HomePage.php');
        exit;
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

    function user_navigation() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (isset($_SESSION['Usuário'])) {
                return "
                <button class='nav_login' id='buy'>
                    <svg viewBox='0 0 28 28' width='20px' height='20px' fill='none' xmlns='http://www.w3.org/2000/svg'>
                        <g id='SVGRepo_bgCarrier' stroke-width='0'></g>
                        <g id='SVGRepo_tracerCarrier' stroke-linecap='round' stroke-linejoin='round'></g>
                        <g id='SVGRepo_iconCarrier'>
                            <path clip-rule='evenodd' d='M1.82047 1C1.36734 1 1 1.35728 1 1.79801V2.39948C1 2.84021 1.36734 3.19749 1.82047 3.19749H3.72716C4.03867 3.19749 4.3233 3.36906 4.46192 3.64038L5.4947 5.93251C5.53326 6.00798 5.56364 6.09443 5.62081 6.15194L10.057 16.4429C10.0129 16.4634 9.97056 16.4883 9.93075 16.5176C8.70163 17.4226 7.87009 18.5878 7.87001 19.7604C7.86996 20.4429 8.16289 21.0807 8.75002 21.5212C9.30752 21.9394 10.0364 22.1118 10.8189 22.1118H10.8446C10.336 22.6308 10.0238 23.3336 10.0238 24.1072C10.0238 25.7049 11.3554 27 12.998 27C14.6406 27 15.9722 25.7049 15.9722 24.1072C15.9722 23.3336 15.66 22.6308 15.1513 22.1118H19.0494C18.5408 22.6308 18.2285 23.3336 18.2285 24.1072C18.2285 25.7049 19.5601 27 21.2027 27C22.8454 27 24.177 25.7049 24.177 24.1072C24.177 23.3336 23.8647 22.6308 23.3561 22.1118H23.9718C24.425 22.1118 24.7923 21.7545 24.7923 21.3138V20.9148C24.7923 20.474 24.425 20.1167 23.9718 20.1167H10.8189C10.3192 20.1167 10.0864 20.0041 10.0028 19.9414C9.94878 19.9009 9.92119 19.8618 9.9212 19.7606C9.92122 19.4917 10.1711 18.8708 11.069 18.1827C11.1084 18.1524 11.1453 18.1194 11.1792 18.084C11.2692 18.1089 11.3635 18.1221 11.4601 18.1221H23.9235C24.4248 18.1221 24.8527 17.7696 24.9351 17.2885L26.9858 5.31837C27.09 4.71036 26.6079 4.1569 25.9742 4.1569H7.35431C7.1981 4.1569 7.05618 4.06597 6.9909 3.92405L5.84968 1.44289C5.71106 1.17157 5.42642 1 5.11492 1H1.82047ZM8.47667 6.15194C8.18952 6.15194 7.99591 6.44552 8.10899 6.70946L12.04 15.8846C12.103 16.0317 12.2476 16.1271 12.4076 16.1271H22.7173C22.9122 16.1271 23.0787 15.9867 23.1116 15.7946L24.6834 6.61948C24.7253 6.37513 24.5371 6.15194 24.2892 6.15194H8.47667ZM11.8698 24.1072C11.8698 23.5012 12.3749 23.0099 12.998 23.0099C13.621 23.0099 14.1261 23.5012 14.1261 24.1072C14.1261 24.7132 13.621 25.2045 12.998 25.2045C12.3749 25.2045 11.8698 24.7132 11.8698 24.1072ZM21.2027 23.0099C20.5797 23.0099 20.0746 23.5012 20.0746 24.1072C20.0746 24.7132 20.5797 25.2045 21.2027 25.2045C21.8258 25.2045 22.3309 24.7132 22.3309 24.1072C22.3309 23.5012 21.8258 23.0099 21.2027 23.0099Z' fill='#ffffff' fill-rule='evenodd'></path>
                        </g>
                    </svg>
                </button>
                <button class='nav_login' id='navLogin'>
                    <img src='profile/profile-default-icon.png' width='20px' height='20px' alt='user_photo' id='photoP'>
                    " . htmlspecialchars($_SESSION['Usuário']) . "
                </button>
                <div id='userMenu' class='menu'>
                    <ul id='header_menu'>
                        <li class='menu_list'><a href='../pages/AccountPage.php' class='item_menu'>Configurações</a></li>
                        <li class='menu_list'><a href='logOut.php' class='item_menu'>Sair</a></li>
                    </ul>
                </div>";
            } else {
                return '
                <nav id="button">
                    <div class="button" id="button_reg"><a id="registro" href="../pages/Registro.php">Cadastrar</a></div>
                    <div class="button" id="button_log"><a id="login" href="../pages/Login.php">Login</a></div>
                </nav>';
            }
        }
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</head>

<body>
    <header id="header_container">
        <div class="header_home">
            <?= custom_header(); ?>
        </div>
        <div class="container_button">
            <?= user_navigation(); ?>
        </div>
    </header>
    <div class="header-details_user">
        <div id="user">
            <img id="photoP" src="profile/profile-default-icon.png" alt="Foto do Perfil" width="100px" height="100px" alt="foto de perfil" />
            <svg viewBox="0 0 24 24" width="24px" height="24px" fill="none" xmlns="http://www.w3.org/2000/svg" id="svg_edit" data-toggle="modal" data-target="#exampleModal" data-foto="profile/<?php echo $novo_nome; ?>">
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
                <div class="button" id="btn-user" data-toggle="modal" data-target="#exampleModal">
                    <svg viewBox="0 0 24 24" width="20px" height="20px" fill="none" xmlns="http://www.w3.org/2000/svg" class="svg_edit">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M11 4H7.2C6.0799 4 5.51984 4 5.09202 4.21799C4.71569 4.40974 4.40973 4.7157 4.21799 5.09202C4 5.51985 4 6.0799 4 7.2V16.8C4 17.9201 4 18.4802 4.21799 18.908C4.40973 19.2843 4.71569 19.5903 5.09202 19.782C5.51984 20 6.0799 20 7.2 20H16.8C17.9201 20 18.4802 20 18.908 19.782C19.2843 19.5903 19.5903 19.2843 19.782 18.908C20 18.4802 20 17.9201 20 16.8V12.5M15.5 5.5L18.3284 8.32843M10.7627 10.2373L17.411 3.58902C18.192 2.80797 19.4584 2.80797 20.2394 3.58902C21.0205 4.37007 21.0205 5.6364 20.2394 6.41745L13.3774 13.2794C12.6158 14.0411 12.235 14.4219 11.8012 14.7247C11.4162 14.9936 11.0009 15.2162 10.564 15.3882C10.0717 15.582 9.54378 15.6885 8.48793 15.9016L8 16L8.04745 15.6678C8.21536 14.4925 8.29932 13.9048 8.49029 13.3561C8.65975 12.8692 8.89125 12.4063 9.17906 11.9786C9.50341 11.4966 9.92319 11.0768 10.7627 10.2373Z" stroke="#474747" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </g>
                    </svg>
                </div>

                <input type="text" placeholder="e-mail" name="inputEmailLog" id="inputEmailLog" class="input" value="<?php echo $email ?>">
                
                <i class="bi bi-eye-slash" id="togglePassword"></i>
                <input type="password" placeholder="senha" name="inputPasswordLog" id="inputPasswordLog" class="input" value="<?php echo $senha ?>"/>
                <div class="button" id="btn-pass" data-toggle="modal" data-target="#exampleModal">
                    <svg viewBox="0 0 24 24" width="20px" height="20px" fill="none" xmlns="http://www.w3.org/2000/svg" class="svg_edit">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M11 4H7.2C6.0799 4 5.51984 4 5.09202 4.21799C4.71569 4.40974 4.40973 4.7157 4.21799 5.09202C4 5.51985 4 6.0799 4 7.2V16.8C4 17.9201 4 18.4802 4.21799 18.908C4.40973 19.2843 4.71569 19.5903 5.09202 19.782C5.51984 20 6.0799 20 7.2 20H16.8C17.9201 20 18.4802 20 18.908 19.782C19.2843 19.5903 19.5903 19.2843 19.782 18.908C20 18.4802 20 17.9201 20 16.8V12.5M15.5 5.5L18.3284 8.32843M10.7627 10.2373L17.411 3.58902C18.192 2.80797 19.4584 2.80797 20.2394 3.58902C21.0205 4.37007 21.0205 5.6364 20.2394 6.41745L13.3774 13.2794C12.6158 14.0411 12.235 14.4219 11.8012 14.7247C11.4162 14.9936 11.0009 15.2162 10.564 15.3882C10.0717 15.582 9.54378 15.6885 8.48793 15.9016L8 16L8.04745 15.6678C8.21536 14.4925 8.29932 13.9048 8.49029 13.3561C8.65975 12.8692 8.89125 12.4063 9.17906 11.9786C9.50341 11.4966 9.92319 11.0768 10.7627 10.2373Z" stroke="#474747" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </g>
                    </svg>
                </div>
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

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">Alterar</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="container_content">
                <!-- JS -->
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="saveButton">Salvar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>

    <script type="module" src="../js/Account.js"></script>
    <script type="module" src="../js/homePage.js"></script>
    <script>
        // Converta os dados do PHP para JSON e insira como uma variável JavaScript
        const userData = <?php echo json_encode([
            'Usuário' => $usuario_nome
        ]); ?>;
    </script>
</body>

</html>