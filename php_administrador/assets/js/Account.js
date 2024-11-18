
document.addEventListener('DOMContentLoaded',()=>{

    console.log('==============================================================CONSOLE DEBUG==============================================================');

    
    const seta = document.getElementsByClassName('triangle')[0];
    let buttonUser = document.getElementById('item_usuario');
    let buttonAuth = document.getElementById('item_autenticacao');
    let buttonShop = document.getElementById('item_compras');
    const user_photo = document.getElementById('user');

    let inputBoxUser = document.getElementById('user_form');
    let inputBoxAuth = document.getElementById('auth_form');
    let inputBoxShop = document.getElementById('shop_form');

    document.getElementById('inputUserLog').disabled = true;
    document.getElementById('inputEmailLog').disabled = true;
    document.getElementById('inputPasswordLog').disabled = true;

    document.getElementById('auth_form').style.display = 'none';
    document.getElementById('shop_form').style.display = 'none';


    if(user_photo){
        let edit = document.getElementById('svg_edit');
        user_photo.addEventListener("mouseover",()=>{
            edit.style.opacity = 1;
            edit.style.cursor = 'pointer';
        });

        user_photo.addEventListener("mouseout",()=>{
            edit.style.opacity = 0;
        });
    }



    if (buttonUser) {
        buttonUser.addEventListener('click', (event) => {
            event.preventDefault(); 
            seta.style.display = 'flex';
            seta.style.top = '9.5vh';
            seta.style.borderColor = 'transparent transparent rgb(187, 187, 187) transparent';
            inputBoxUser.style.display = 'block';
            inputBoxAuth.style.display = 'none';
            inputBoxShop.style.display = 'none';
        });
    }

    if (buttonAuth) {
        buttonAuth.addEventListener('click', (event) => {
            event.preventDefault(); // Previne o recarregamento da página
            seta.style.top = '14.5vh';
            seta.style.borderColor = 'transparent transparent rgb(187, 187, 187) transparent';
            inputBoxUser.style.display = 'none';
            inputBoxAuth.style.display = 'block';
            inputBoxShop.style.display = 'none';
        });
    }

    if(buttonShop){
        buttonShop.addEventListener('click',(event) =>{
            event.preventDefault();
            seta.style.top = '19.5vh';
            seta.style.borderColor = 'transparent transparent white transparent';
            inputBoxUser.style.display = 'none';
            inputBoxAuth.style.display = 'none';
            inputBoxShop.style.display = 'block';
        })
    }
});





