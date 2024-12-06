document.addEventListener('DOMContentLoaded', function() {
    console.log('==============================================================CONSOLE DEBUG==============================================================');

    const botao = document.querySelector("#navLogin");

    if (botao) {
        botao.addEventListener("click", function(event) {
            const menu = document.getElementById("userMenu");
            
            if (menu) {
                console.log('botão funcionando!');
                // Alterna a classe 'show' no menu ao clicar no botão
                menu.classList.toggle('show');
            }
        });
    }
    
    // Fecha o menu se clicar fora dele
    document.addEventListener("click", function(event) {
        const menu = document.getElementById("userMenu");
        const navLogin = document.getElementById("navLogin");
    
        if (menu && !menu.contains(event.target) && !navLogin.contains(event.target)) {
            menu.classList.remove('show');
        }
    });

    document.getElementById("buy").addEventListener("click", ()=>{
        window.location.href = "carrinho.php";
    });

});
