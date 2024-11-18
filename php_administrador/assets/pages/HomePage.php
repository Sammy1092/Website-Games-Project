<?php 

    require_once $_SERVER['DOCUMENT_ROOT'] . '/php_administrador/index.php';

    function custom_header(){
        $header_first = [
            'Home' => '../pages/HomePage.php',
            'Pagina exemplo' => '',
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
    <link rel="icon" href="../image/home.ico" type="image/home-icon">
    <title>Home</title>
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
                                            <li class='menu_list'><a href='logOut.php' class='item_menu'>Sair</a></li>
                                        </ul>
                                    </div>
                                </nav>";
                        } else {
                            // Exibe os botões "Cadastrar" e "Login" se o usuário não estiver logado
                            echo '<nav id="button">';
                            echo '<div class="button" id="button_reg"><a id="registro" href="../pages/Registro.php">Cadastrar</a></div>';
                            echo '<div class="button" id="button_log"><a id="login" href="../pages/Login.php">Login</a></div>';
                            echo '</nav>';
                        }
                    }
                ?>
            </div>
        </div>

    </header>
    <div>
        <img src="" width="100%" height="40%" alt="banner">
        <hr>
        <nav class="container_content">
            <div id="text_content">
                <span>
                Espaço para Game Devs, onde podem ver dicas, recursos e ver outros desenvolvedores falando sobre tal programação.
                </span>
            </div>
        </nav>
    </div>

    <script type="module" src="../js/homePage.js"></script>

</body>
</html>