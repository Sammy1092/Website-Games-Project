
document.addEventListener('DOMContentLoaded',()=>{

    console.log('==============================================================CONSOLE DEBUG==============================================================');


    const svg        =                  document.querySelector('svg');
    //
    const seta       = document.getElementsByClassName('triangle')[0];
    let buttonUser   =        document.getElementById('item_usuario');
    let buttonAuth   =   document.getElementById('item_autenticacao');
    let buttonShop   =        document.getElementById('item_compras');
    const user_photo =                document.getElementById('user');
    let EditUser     =            document.getElementById('btn-user');
    let EditPass     =            document.getElementById('btn-pass');

    const eyes       =      document.querySelector('#togglePassword');

    let inputBoxUser = document.getElementById('user_form');
    let inputBoxAuth = document.getElementById('auth_form');
    let inputBoxShop = document.getElementById('shop_form');

    document.getElementById('inputUserLog').disabled     = true;
    document.getElementById('inputEmailLog').disabled    = true;
    document.getElementById('inputPasswordLog').disabled = true;

    document.getElementById('auth_form').style.display = 'none';
    document.getElementById('shop_form').style.display = 'none';
    document.getElementById('svg_edit').style.opacity  = 0;


    //#region PHOTO EDIT
    //MODAL

    if (svg) {
        svg.addEventListener('click', () => {
            console.log('SVG foi clicado!'); // Debug

            const containerPhoto = document.getElementById('container_content');
            const Search = document.createElement('input');
            const profile_photo = document.createElement('div');

            

            document.getElementsByClassName('modal-title')[0].style.opacity = 0;

            if (containerPhoto && document.getElementById('exampleModal')) {
                console.log('Container encontrado e limpando conteúdo.');
            
                // Limpa o conteúdo do container
                containerPhoto.innerHTML = '';
                containerPhoto.style.flexDirection = 'row'; // Alinha os elementos verticalmente
            
                // Cria o formulário
                const gallery = document.createElement('form');
                gallery.classList.add('gallery');
                gallery.style.width = '100%';

                gallery.method = "POST";
                gallery.enctype = "multipart/form-data";
                gallery.style.display = 'flex';
                gallery.style.flexDirection = "column";
                gallery.style.marginTop = '10px';
                gallery.textContent = 'Galeria de Fotos';

            
                // Cria a div que fica acima do formulário
                const profilePhotoDiv = document.createElement('div');
                profilePhotoDiv.classList.add("profile");
                profilePhotoDiv.style.display = 'flex';
                profilePhotoDiv.style.flexDirection = 'column';
                profilePhotoDiv.style.padding = "15px";
                profilePhotoDiv.style.margin = "15px";
                profilePhotoDiv.style.borderRight = 'solid 0.3px #ccc';

                //
                const photoP = document.createElement('img');
                photoP.style.width = '90px';
                photoP.style.height = '90px';
                photoP.src = '../image/profile-default-icon.png';
                photoP.alt = 'foto de perfil';
                photoP.style.position = 'relative';
                photoP.style.top = '30px';
                photoP.style.left = '20px';              
            
                // Cria o input de arquivo
                const searchInput = document.createElement('input');
                searchInput.type = 'file';
                searchInput.name = 'arquivo';
                searchInput.classList.add('ButtonSearch');
                searchInput.style.marginTop = '10px';
                searchInput.style.marginBottom = '30px';

            
                // Adiciona o input ao formulário
                gallery.appendChild(searchInput);
            
                // Move o botão "Salvar" para o formulário
                const saveButton = document.getElementById('saveButton'); // Botão já existente no HTML
                saveButton.type = 'submit'; // Certifica-se de que o tipo seja "submit"
                gallery.appendChild(saveButton);
            
                // Adiciona os elementos ao container
                containerPhoto.appendChild(photoP);
                containerPhoto.appendChild(profilePhotoDiv);
                containerPhoto.appendChild(gallery);
            
                // Certifica-se de que o container está visível
                containerPhoto.style.display = 'flex';
            
                console.log('Elemento Div (Profile Photo):', profilePhotoDiv);
                console.log('Elemento Formulário (Gallery):', gallery);
                console.log('Elemento Input (Search):', searchInput);
                console.log('Elemento Button (Save):', saveButton);
            }else {
                console.error('Container ou Modal não encontrado no DOM.');
            }

          
        });
    } else {
        console.error('Elemento SVG não foi encontrado.');
    }

    //
    if(user_photo){
        let edit = document.getElementById('svg_edit');
        user_photo.addEventListener("mouseover",()=>{
            edit.style.opacity =         1;
            edit.style.cursor  = 'pointer';
        });

        user_photo.addEventListener("mouseout",()=>{
            edit.style.opacity = 0;
        });
    }
    //#endregion

    if (buttonUser) {
        buttonUser.addEventListener('click', (event) => {
            event.preventDefault(); 
            seta.style.display         =                                                   'flex';
            seta.style.top             =                                                  '9.5vh';
            seta.style.borderColor     = 'transparent transparent rgb(187, 187, 187) transparent';
            inputBoxUser.style.display =                                                  'block';
            inputBoxAuth.style.display =                                                   'none';
            inputBoxShop.style.display =                                                   'none';
        });
    }

    if (buttonAuth) {
        buttonAuth.addEventListener('click', (event) => {
            event.preventDefault(); // Previne o recarregamento da página
            seta.style.top             =                                                 '14.5vh';
            seta.style.borderColor     = 'transparent transparent rgb(187, 187, 187) transparent';
            inputBoxUser.style.display =                                                   'none';
            inputBoxAuth.style.display =                                                  'block';
            inputBoxShop.style.display =                                                   'none';
        });
    }

    if(buttonShop){
        buttonShop.addEventListener('click',(event) =>{
            event.preventDefault();
            seta.style.top             =                                    '19.5vh';
            seta.style.borderColor     = 'transparent transparent white transparent';
            inputBoxUser.style.display =                                      'none';
            inputBoxAuth.style.display =                                      'none';
            inputBoxShop.style.display =                                     'block';
        })
    }


    //MODAL USER

    EditUser.addEventListener('click', () => {
        let container = document.getElementById('container_content');
        
        // Verificar se o modal está presente
        if (document.getElementById('exampleModal')) {
            // Limpar o conteúdo do container antes de adicionar os novos inputs
            container.innerHTML = ''; // Isso remove todos os elementos dentro de 'container_content'
            
            // Criar um novo input de usuário
            let inputUsuario        = document.createElement("input");
            inputUsuario.type       =                          "text";
            inputUsuario.className  =            "exampleTextUsuario";
            inputUsuario.value      =                userData.Usuário; // Usuário vindo do PHP
            container.appendChild(inputUsuario);
        }
    });
    
    EditPass.addEventListener('click', () => {
        let container = document.getElementById('container_content');
        
        // Verificar se o modal está presente
        if (document.getElementById('exampleModal')) {
            // Limpar o conteúdo do container antes de adicionar os novos inputs
            container.innerHTML = ''; // Isso remove todos os elementos dentro de 'container_content'
            
            // Criar os novos inputs de senha
            let inputSenha           = document.createElement("input");
            inputSenha.type          =                      "password";
            inputSenha.className     =              "exampleTextSenha";
            inputSenha.placeholder   =                    "Nova senha";
            inputSenha.value         =                              ""; // Senha vindo do PHP
            container.appendChild(inputSenha);
            
            // Criar o input de confirmação de senha
            let inputConfSenha = document.createElement("input");
            inputConfSenha.type = "password";
            inputConfSenha.className = "exampleTextConfSenha";
            inputConfSenha.placeholder   = "Confirmar a nova senha";
            inputConfSenha.value = ""; // Senha vindo do PHP
            container.appendChild(inputConfSenha);
        }
    });  
    
    
    eyes.addEventListener("click", function () {
        let inputSenhaLog = document.getElementById('inputPasswordLog')
        // toggle the type attribute
        const type = inputSenhaLog.getAttribute("type") === "password" ? "text" : "password";
        inputSenhaLog.setAttribute("type", type);
        
        // toggle the icon
        eyes.classList.toggle("bi-eye");
        eyes.classList.toggle("bi-eye-slash");
    });

    // prevent form submit
    const form = document.querySelector("form");
    form.addEventListener('submit', function (e) {
        e.preventDefault();
    });
});    





