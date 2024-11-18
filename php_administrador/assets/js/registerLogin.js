console.log('==============================================================CONSOLE DEBUG==============================================================');

document.addEventListener('DOMContentLoaded', () => {
    
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

    $(function() {
        var url_termos = "https://www.iubenda.com/termos-e-condicoes/76266882";
        var url_privacidade = "URL DA PÁGINA DE PRIVACIDADE";
        
        // Criação do HTML do checkbox com links de termos de uso e política de privacidade
        var html = '<div class="row-fluid"> \
                        <div class="span-6"> \
                            <div class="caixa-sombreada borda-principal"> \
                                <fieldset class="form-horizontal"> \
                                    <div class="control-group required"> \
                                        <input id="marcar" type="checkbox" style="margin-top: -0.5%"> \
                                        Li e concordo com os <a href="' + url_termos + '" target="_blank">termos de uso</a> \
                                        e <a href="' + url_privacidade + '" target="_blank">política de privacidade</a> \
                                    </div> \
                                </fieldset> \
                            </div> \
                        </div> \
                    </div>';
        
        // Insere o HTML com o checkbox após a área .dados-pessoais
        $(".form_user .dados-pessoais").after(html);
        
        // Validação para garantir que o checkbox esteja marcado antes de enviar
        $(document).on("click", ".form_user .botao", function() {
            if(!$("#marcar").is(":checked")) {
                $("#marcar").parent().css("border", "1px #f00 solid");
                alert("Você deve concordar com os termos e a política de privacidade.");
                return false;
            }
            // Continua com a ação do botão (envio de dados) se o checkbox estiver marcado
            alert("Formulário enviado com sucesso!");
        });
    });
});
