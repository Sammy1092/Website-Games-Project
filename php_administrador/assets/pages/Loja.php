<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/php_administrador/index.php';

    // Conectar ao banco de dados
    $conn = new mysqli('localhost', 'root', '', 'gameshop');

    // Verificar a conexão
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    
    function custom_header() {
        $header_items = [
            'Home' => '../pages/HomePage.php',
            'Loja' => '../pages/Loja.php'
        ];
    
        $html = '<ul class="list_header">';
        foreach ($header_items as $name => $url) {
            $html .= "<li class='name'><a class='pages' href='$url'>$name</a></li>"; 
        }
        $html .= '</ul>';
    
        return $html;
    }
    
    function user_navigation() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (isset($_SESSION['Usuário'])) {
                return "
                <button class='nav_login' id='buy' onclick='redirectClick'>
                    <svg viewBox='0 0 28 28' width='20px' height='20px' fill='none' xmlns='http://www.w3.org/2000/svg'>
                        <g id='SVGRepo_bgCarrier' stroke-width='0'></g>
                        <g id='SVGRepo_tracerCarrier' stroke-linecap='round' stroke-linejoin='round'></g>
                        <g id='SVGRepo_iconCarrier'>
                            <path clip-rule='evenodd' d='M1.82047 1C1.36734 1 1 1.35728 1 1.79801V2.39948C1 2.84021 1.36734 3.19749 1.82047 3.19749H3.72716C4.03867 3.19749 4.3233 3.36906 4.46192 3.64038L5.4947 5.93251C5.53326 6.00798 5.56364 6.09443 5.62081 6.15194L10.057 16.4429C10.0129 16.4634 9.97056 16.4883 9.93075 16.5176C8.70163 17.4226 7.87009 18.5878 7.87001 19.7604C7.86996 20.4429 8.16289 21.0807 8.75002 21.5212C9.30752 21.9394 10.0364 22.1118 10.8189 22.1118H10.8446C10.336 22.6308 10.0238 23.3336 10.0238 24.1072C10.0238 25.7049 11.3554 27 12.998 27C14.6406 27 15.9722 25.7049 15.9722 24.1072C15.9722 23.3336 15.66 22.6308 15.1513 22.1118H19.0494C18.5408 22.6308 18.2285 23.3336 18.2285 24.1072C18.2285 25.7049 19.5601 27 21.2027 27C22.8454 27 24.177 25.7049 24.177 24.1072C24.177 23.3336 23.8647 22.6308 23.3561 22.1118H23.9718C24.425 22.1118 24.7923 21.7545 24.7923 21.3138V20.9148C24.7923 20.474 24.425 20.1167 23.9718 20.1167H10.8189C10.3192 20.1167 10.0864 20.0041 10.0028 19.9414C9.94878 19.9009 9.92119 19.8618 9.9212 19.7606C9.92122 19.4917 10.1711 18.8708 11.069 18.1827C11.1084 18.1524 11.1453 18.1194 11.1792 18.084C11.2692 18.1089 11.3635 18.1221 11.4601 18.1221H23.9235C24.4248 18.1221 24.8527 17.7696 24.9351 17.2885L26.9858 5.31837C27.09 4.71036 26.6079 4.1569 25.9742 4.1569H7.35431C7.1981 4.1569 7.05618 4.06597 6.9909 3.92405L5.84968 1.44289C5.71106 1.17157 5.42642 1 5.11492 1H1.82047ZM8.47667 6.15194C8.18952 6.15194 7.99591 6.44552 8.10899 6.70946L12.04 15.8846C12.103 16.0317 12.2476 16.1271 12.4076 16.1271H22.7173C22.9122 16.1271 23.0787 15.9867 23.1116 15.7946L24.6834 6.61948C24.7253 6.37513 24.5371 6.15194 24.2892 6.15194H8.47667ZM11.8698 24.1072C11.8698 23.5012 12.3749 23.0099 12.998 23.0099C13.621 23.0099 14.1261 23.5012 14.1261 24.1072C14.1261 24.7132 13.621 25.2045 12.998 25.2045C12.3749 25.2045 11.8698 24.7132 11.8698 24.1072ZM21.2027 23.0099C20.5797 23.0099 20.0746 23.5012 20.0746 24.1072C20.0746 24.7132 20.5797 25.2045 21.2027 25.2045C21.8258 25.2045 22.3309 24.7132 22.3309 24.1072C22.3309 23.5012 21.8258 23.0099 21.2027 23.0099Z' fill='#ffffff' fill-rule='evenodd'></path>
                        </g>
                    </svg>
                </button>
                <button class='nav_login' id='navLogin'>
                    <img src='profile/profile-default-icon.png'.width='20px' height='20px' alt='user_photo' id='photoP''>
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

    // Consulta SQL para pegar todos os jogos
    $sql = "SELECT games.ID, games.Nome, games.Lancamento, category.Nome AS Categoria, games.JogoP
            FROM games
            JOIN category ON games.ID_Categoria = category.ID
            ORDER BY games.Nome ASC";

    // Executar a consulta
    $result = $conn->query($sql);

    // Verificar se há resultados
    if ($result->num_rows > 0) {
       while($row = $result->fetch_assoc()){
            echo "<div class='card'>";
            echo "<img src='upload/" . htmlspecialchars($row['JogoP']) . "' width='100%' height='300px' class='foto_jogo' alt='banner do jogo'/>";
            echo "<span>".htmlspecialchars($row['Nome'])."</span>";
            echo "<p><strong>Lançamento:</strong> " . htmlspecialchars($row['Lancamento']) . "</p>";
            echo "<p><strong>Categoria:</strong> " . htmlspecialchars($row['Categoria']) . "</p>";
            echo "</div>";
       }
    } else {
        echo "Nenhum jogo encontrado.";
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loja</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../css/Shop.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/homePage.css">

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

    <!-- JS -->

    <div id="loader">
        <div class="spinner-grow text-primary" id="load"></div>
    </div>
</body>
</html>
