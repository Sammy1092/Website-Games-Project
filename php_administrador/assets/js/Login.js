console.log("======================= REGISTRO DO CONSOLE =======================");


document.getElementById('buttonLog').addEventListener('click',()=>{
    console.log('teste')
    let userLog            =      document.getElementById('inputUserLog').value.trim();
    let passwordLog        =  document.getElementById('inputPasswordLog').value.trim();

    if(userLog == "" && passwordLog == ""){
        alert('Preencha o campo de Login e Senha por favor');
    }else if(userLog == ""){
        alert('Preencha o campo de Login por favor!');
    }else if(passwordLog == ""){
        alert('Preencha o campo de Senha por favor!');
    }else {
        // Submeter o formulário se a validação passar
        document.getElementById('container_formLogin').submit();
    }
    
})