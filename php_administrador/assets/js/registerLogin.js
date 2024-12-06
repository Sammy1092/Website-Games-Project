
document.addEventListener('DOMContentLoaded', () => {
    console.log('==============================================================CONSOLE DEBUG==============================================================');
    
    document.getElementById('loader').style.display = 'none';

    function setupButtonListener() {
        const button = document.getElementById('button');

        if (button) {
            button.addEventListener('click', (e) => {
                e.preventDefault(); // Previne o comportamento padrão do formulário
                
                let user            =      document.getElementById('inputUser').value.trim();
                let password        =  document.getElementById('inputPassword').value.trim();
                let ConfPassword    = document.getElementById('inputPassword2').value.trim();

                // Validação dos campos
                if (user === "" && password === "" && ConfPassword === "") {
                    alert('Preenchimento de Campos obrigatório!');
                } else if (user === "") {
                    alert('Preenchimento do Campo "nome do usuário" obrigatorio!');
                } else if (password === "") {
                    alert('Preenchimento do Campo "senha" obrigatorio!');
                } else if (ConfPassword === "") {
                    alert('Preenchimento do Campo "confirmar senha" obrigatorio!');
                } else if (password !== ConfPassword) {
                    alert('As senhas não coincidem!');
                } else {
                    // Submeter o formulário se a validação passar
                    document.getElementById('form_reg').submit();
                }
            });
        }
    }

    setupButtonListener();


});
