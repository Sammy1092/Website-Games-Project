<?php

// Destrói todas as variáveis de sessão
$_SESSION = array();

// Se você deseja destruir completamente a sessão, também deve apagar o cookie de sessão
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finalmente, destrói a sessão
session_destroy();

// Redireciona para a página inicial ou de login
header("Location: ../pages/HomePage.php");

?>
