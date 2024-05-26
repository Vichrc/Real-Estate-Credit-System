

//Mostrar Senha

function mostrarSenha3(){
    var tipo = document.getElementById("inputsenha");
    var tipo2 = document.getElementById("inputrepetirsenha");
    var tipo3 = document.getElementById("senhaantiga");
    var imginput = document.getElementById("imgsenhacadastro");
    var imginput2 = document.getElementById("inputconfirmsenha");
    var imginput3 = document.getElementById("imgsenhaantiga");


    if(tipo.type == "password"){
        tipo.type = "text";
        tipo2.type = "text";
        tipo3.type = "text";
        imginput.src = "../../../css/img/olhos-cruzados.png";
        imginput2.src = "../../../css/img/olhos-cruzados.png";
        imginput3.src = "../../../css/img/olhos-cruzados.png";
    }else{
        tipo.type = "password";
        tipo2.type = "password";
        tipo3.type = "password";
        imginput.src = "../../../css/img/olho.png";
        imginput2.src = "../../../css/img/olho.png";
        imginput3.src = "../../../css/img/olho.png";
    }
}

function mostrarSenha2(){
    var tipo = document.getElementById("inputsenha");
    var tipo2 = document.getElementById("inputrepetirsenha")
    var imginput = document.getElementById("imgsenhacadastro");
    var imginput2 = document.getElementById("inputconfirmsenha");

    if(tipo.type == "password"){
        tipo.type = "text";
        tipo2.type = "text";
        imginput.src = "../../../css/img/olhos-cruzados.png";
        imginput2.src = "../../../css/img/olhos-cruzados.png";
    }else{
        tipo.type = "password";
        tipo2.type = "password";
        imginput.src = "../../../css/img/olho.png";
        imginput2.src = "../../../css/img/olho.png";
    }
}


function mostrarSenha(){
    var tipo = document.getElementById("inputsenha");
    var tipo2 = document.getElementById("inputrepetirsenha")
    var imginput = document.getElementById("imgsenhacadastro");
    var imginput2 = document.getElementById("inputconfirmsenha");

    if(tipo.type == "password"){
        tipo.type = "text";
        tipo2.type = "text";
        imginput.src = "css/img/olhos-cruzados.png";
        imginput2.src = "css/img/olhos-cruzados.png";
    }else{
        tipo.type = "password";
        tipo2.type = "password";
        imginput.src = "css/img/olho.png";
        imginput2.src = "css/img/olho.png";

    }
}


//Validação registro de usuario
function handleFormSubmit() {
    // Chame a função que já existe no onSubmit
    var resultadoValidacao = validarForm();

    // Se a validação for bem-sucedida, chame a função loadingRegister
    if (resultadoValidacao) {
        loadingRegister();
    }

    // Retorne o resultado da validação (pode ajustar conforme necessário)
    return resultadoValidacao;
}

function mostrarLoader() {
    var resultadoValidacao = validarForm();
    var divSecText = document.getElementById("btnCriarLoginSecText");
    var divLoader = document.getElementById("btnCriarLoginSecLoader");

    // Torna a div com id "btnCriarLoginSecText" invisível
    if (resultadoValidacao) {divSecText.style.display = "none";

    // Remove a propriedade display "none" da div com id "btnCriarLoginSecLoader"
    divLoader.style.display = "flex"; // ou "inline" dependendo do estilo que você deseja aplicar
    }

    return resultadoValidacao;
}




function validarForm() {
    var isValidFullName = validarFormFullName();
    var isValidDoc = validarFormDoc();
    var isValidTel = validarFormTel();
    var isValidEmail = validarFormEmail();
    var isValidPassword = validarFormPassword();
    var isValidPasswordConfirm = validarFormPasswordConfirm();
    var isValidPasswords = validarIgualdadePassword();
    var isValidCheckBox = validarCheckBox();  

    // Retorna true apenas se as validações forem verdadeiras
    return isValidFullName && isValidDoc && isValidTel && isValidEmail && isValidPassword && isValidPasswordConfirm && isValidPasswords && isValidCheckBox;
}

function loadingRegister() {
    var loaderarea = document.getElementById("loaderarea");

    if (loaderarea.classList.contains("dis-hiden")) {
        loaderarea.classList.remove('dis-hiden');
    } else {
        loaderarea.classList.add('dis-hiden');
    }
}


function validarFormFullName() {
    var inputCampo = document.getElementById('inputfullname');
    var mensagemErro = document.getElementById('mensagemErro');
    var labelCampo = document.querySelector('label[for="inputfullname"]');


    // Verifica se o campo está vazio
    if (inputCampo.value.trim() === '') {
        // Adiciona a classe 'borderdanger' ao input
        inputCampo.classList.add('borderdanger');
        labelCampo.classList.add('colordanger')
        
        // Exibe a mensagem de erro com o ícone
        mensagemErro.innerHTML = '<i class="fi fi-ss-exclamation"></i> Digite seu nome';
        
        // Impede o envio do formulário
        return false;
    } else {
        // Remove a classe 'borderdanger' do input
        inputCampo.classList.remove('borderdanger');
        labelCampo.classList.remove('colordanger')

        
        // Limpa a mensagem de erro
        mensagemErro.textContent = '';
        
        // Permite o envio do formulário
        return true;
    }
    
}

function validarFormDoc() {
    var inputCampoDoc = document.getElementById('inputdoc');
    var mensagemErroDoc = document.getElementById('mensagemErroDoc');
    var labelCampoDoc = document.querySelector('label[for="inputdoc"]');

    if (inputCampoDoc.value.trim() === '' ) {
        inputCampoDoc.classList.add('borderdanger');
        labelCampoDoc.classList.add('colordanger')
        mensagemErroDoc.innerHTML = '<i class="fi fi-ss-exclamation"></i> Digite o seu CPF/CNPJ';
        return false;
    } else {
        if(inputCampoDoc.value.length < 14){
            inputCampoDoc.classList.add('borderdanger');
            labelCampoDoc.classList.add('colordanger')
            mensagemErroDoc.innerHTML = '<i class="fi fi-ss-exclamation"></i>Digite o número do seu CPF';
            return false;
        }
        inputCampoDoc.classList.remove('borderdanger');
        labelCampoDoc.classList.remove('colordanger')
        mensagemErroDoc.textContent = '';
        return true;
    }
}

function validarFormTel() {
    var inputCampoTel = document.getElementById('inputnumberphone');
    var mensagemErroTel = document.getElementById('mensagemErroTel');
    var labelCampoTel = document.querySelector('label[for="inputnumberphone"]');

    if (inputCampoTel.value.trim() === '' ) {
        inputCampoTel.classList.add('borderdanger');
        labelCampoTel.classList.add('colordanger')
        mensagemErroTel.innerHTML = '<i class="fi fi-ss-exclamation"></i> Digite o seu n° de telefone';
        return false;
    } else {
        inputCampoTel.classList.remove('borderdanger');
        labelCampoTel.classList.remove('colordanger')
        mensagemErroTel.textContent = '';
        return true;
    }
}

function validarFormEmail() {
    var inputCampoEmail = document.getElementById('inputemail');
    var mensagemErroEmail = document.getElementById('mensagemErroEmail');
    var labelCampoEmail = document.querySelector('label[for="inputemail"]');
    
    if (inputCampoEmail.value.trim() === '' || !inputCampoEmail.value.includes('@')) {
        inputCampoEmail.classList.add('borderdanger');
        labelCampoEmail.classList.add('colordanger');
        mensagemErroEmail.innerHTML = '<i class="fi fi-ss-exclamation"></i> Digite o seu e-mail';
        return false;
    } else {
        inputCampoEmail.classList.remove('borderdanger');
        labelCampoEmail.classList.remove('colordanger');
        mensagemErroEmail.textContent = '';
        return true;
    }
}

function validarFormPassword() {
    var inputCampoPassword = document.getElementById('inputsenha');
    var mensagemErroPassword = document.getElementById('mensagemErroPassword');
    var labelCampoPassword = document.querySelector('label[for="inputsenha"]');
    
    if (inputCampoPassword.value.trim() === '') { 
        inputCampoPassword.classList.add('borderdanger');
        labelCampoPassword.classList.add('colordanger');
        mensagemErroPassword.innerHTML = '<i class="fi fi-ss-exclamation"></i> Digite uma senha';
        return false;
    } else {
        inputCampoPassword.classList.remove('borderdanger');
        labelCampoPassword.classList.remove('colordanger');
        mensagemErroPassword.textContent = '';
        return true;
    }
}

function validarFormPasswordConfirm() {
    var inputCampoPasswordConfirm = document.getElementById('inputrepetirsenha');
    var mensagemErroPasswordConfirm = document.getElementById('mensagemErroPasswordConfirm');
    var labelCampoPasswordConfirm = document.querySelector('label[for="inputrepetirsenha"]');
    
    if (inputCampoPasswordConfirm.value.trim() === '') { 
        inputCampoPasswordConfirm.classList.add('borderdanger');
        labelCampoPasswordConfirm.classList.add('colordanger');
        mensagemErroPasswordConfirm.innerHTML = '<i class="fi fi-ss-exclamation"></i> Digite novamente sua senha';
        return false;
    } else {
        inputCampoPasswordConfirm.classList.remove('borderdanger');
        labelCampoPasswordConfirm.classList.remove('colordanger');
        mensagemErroPasswordConfirm.textContent = '';
        return true;
    }
}

function validarIgualdadePassword(){
    var inputCampoPasswordConfirm = document.getElementById('inputrepetirsenha');
    var mensagemErroPasswordConfirm = document.getElementById('mensagemErroPasswordConfirm');
    var labelCampoPasswordConfirm = document.querySelector('label[for="inputrepetirsenha"]');
    var inputCampoPassword = document.getElementById('inputsenha');
    var mensagemErroPassword = document.getElementById('mensagemErroPassword');
    var labelCampoPassword = document.querySelector('label[for="inputsenha"]');

    if (inputCampoPassword.value.trim() != inputCampoPasswordConfirm.value.trim()){
        mensagemErroPasswordConfirm.innerHTML = '<i class="fi fi-ss-exclamation"></i> As Senhas não são iguais';        
        inputCampoPasswordConfirm.classList.add('borderdanger');
        labelCampoPasswordConfirm.classList.add('colordanger');

        mensagemErroPassword.innerHTML = '<i class="fi fi-ss-exclamation"></i> As Senhas não são iguais';
        inputCampoPassword.classList.add('borderdanger');
        labelCampoPassword.classList.add('colordanger');
        return false;
    } else {
        return true;
    }

}

function validarCheckBox(){
    var termosDeUso = window.document.getElementById("termosdeuso");
    var mensagemErroCheckbox = document.getElementById('mensagemErroCheckbox');
    var aceitouTermos = termosDeUso.checked;
    var labelCampotermosdeuso = document.querySelector('label[for="termosdeuso"]');

    if (!aceitouTermos) {
        termosDeUso.classList.add('borderdanger');
        labelCampotermosdeuso.classList.add('colordanger');
        mensagemErroCheckbox.innerHTML = '<i class="fi fi-ss-exclamation"></i> Aceite os termos para continuar';
        return false;
    } else {
        termosDeUso.classList.remove('borderdanger');
        labelCampotermosdeuso.classList.remove('colordanger');
        mensagemErroCheckbox.textContent = '';
        return true; 
    }

}

