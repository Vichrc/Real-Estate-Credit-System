
function validarCPF(cpf) {
    cpf = cpf.replace(/[^\d]+/g, ''); // Remove caracteres não numéricos

    if (cpf.length !== 11 ||
        cpf === '00000000000' ||
        cpf === '11111111111' ||
        cpf === '22222222222' ||
        cpf === '33333333333' ||
        cpf === '44444444444' ||
        cpf === '55555555555' ||
        cpf === '66666666666' ||
        cpf === '77777777777' ||
        cpf === '88888888888' ||
        cpf === '99999999999') {
        return false;
    }

    // Algoritmo de validação de CPF
    var soma = 0;
    for (var i = 0; i < 9; i++) {
        soma += parseInt(cpf.charAt(i)) * (10 - i);
    }
    var resto = 11 - (soma % 11);
    if (resto === 10 || resto === 11) {
        resto = 0;
    }
    if (resto !== parseInt(cpf.charAt(9))) {
        return false;
    }
    soma = 0;
    for (var i = 0; i < 10; i++) {
        soma += parseInt(cpf.charAt(i)) * (11 - i);
    }
    resto = 11 - (soma % 11);
    if (resto === 10 || resto === 11) {
        resto = 0;
    }
    if (resto !== parseInt(cpf.charAt(10))) {
        return false;
    }
    return true;
}

  // Obtém referências para os elementos select e imagem
  var select = document.getElementById('tipoFinanciamento');
  var image01 = document.getElementById('incognta01');
  var image02 = document.getElementById('incognta02');

  // Adiciona um ouvinte de evento para o evento 'change' no elemento select
  select.addEventListener('change', function() {
      // Obtém o valor selecionado no select
      var selectedOption = select.value;

      // Define o novo nome da imagem com base na opção selecionada
      switch (selectedOption) {
          case 'FI':
              image01.style.display = 'flex';
              image02.style.display = 'none';
              break;
          case 'CGI':
              image01.style.display = 'none';
              image02.style.display = 'flex';
              break;
          default:
              // Define um nome padrão se nenhuma opção válida for selecionada
              image01.style.display = 'flex';
              image02.style.display = 'none';
      }
  });

  //<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< Inicio Imagens Duvida <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<

const img = document.querySelector('.incognta');
const img2 = document.querySelector('.incognta2');
const img5 = document.querySelector('.incognta5');

img.addEventListener('mouseover', function() {
    // Altera o atributo 'src' da imagem quando o mouse passa sobre ela
    img.src = '../../../css/img/incognta01.png';
});

img.addEventListener('mouseleave', function() {
    img.src = '../../../css/img/incognta.png';
});

img2.addEventListener('mouseover', function() {
    // Altera o atributo 'src' da imagem quando o mouse passa sobre ela
    img2.src = '../../../css/img/incognta01.png';
});

img2.addEventListener('mouseleave', function() {
    img2.src = '../../../css/img/incognta.png';
});

img5.addEventListener('mouseover', function() {
    // Altera o atributo 'src' da imagem quando o mouse passa sobre ela
    img5.src = '../../../css/img/incognta01.png';
});

img5.addEventListener('mouseleave', function() {
    img5.src = '../../../css/img/incognta.png';
});

//<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< Final Imagens Duvida <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<

function handleFormSubmit() {
    // Chame a função que já existe no onSubmit
    var resultadoValidacao = validarForm();

    // Se a validação for bem-sucedida, chame a função loadingRegister
    if (resultadoValidacao) {
        console.log("Deu certo")
        
    } else {
        console.log("Deu Erro")
    }

    // Retorne o resultado da validação (pode ajustar conforme necessário)
    return resultadoValidacao;
}


function validarForm() {
    var isValidCPF = validarInputCPF();
    var isValidValorFin = validarvalorfinanciado();
    var isValidTypeFin = validarTipoFinanciamento();
    var isValidValidEstFin = validarEstadoFinanciamento();
    var isValidName = validarNomeComprador();
    var isValidValoeImovel = validarValorImovel();
    var isValidCityFin = validarCidadeFinanciamento();

    // Retorna true apenas se as validações forem verdadeiras
    return isValidCPF && isValidValorFin && isValidValoeImovel && isValidTypeFin && isValidValidEstFin && isValidName && isValidCityFin;
}


document.getElementById('tipoFinanciamento').addEventListener('change', validarTipoFinanciamento);

function validarInputCPF() {
    var inputCampoCPF = document.getElementById('cpfMask');
    var mensagemErroCPF = document.getElementById('mensagemErroCPF');
    var labelCampoCPF = document.querySelector('label[for="cpfMask"]');


    // Verifica se o campo está vazio
    if (inputCampoCPF.value.trim() === '') {
        // Adiciona a classe 'borderdanger' ao input
        inputCampoCPF.classList.add('borderdanger');
        labelCampoCPF.classList.add('colordanger');
        
        // Exibe a mensagem de erro com o ícone
        mensagemErroCPF.innerHTML = '<i class="fi fi-ss-exclamation"></i> Digite o CPF do Comprador!';
        
        // Impede o envio do formulário
        return false;
    } else {


        if(validarCPF(inputCampoCPF.value)){

            // Remove a classe 'borderdanger' do input
            inputCampoCPF.classList.remove('borderdanger');
            labelCampoCPF.classList.remove('colordanger');

            
            // Limpa a mensagem de erro
            mensagemErroCPF.textContent = '';
            
            // Permite o envio do formulário
            return true;

        } else {

            inputCampoCPF.classList.add('borderdanger');
            labelCampoCPF.classList.add('colordanger');
            mensagemErroCPF.innerHTML = '<i class="fi fi-ss-exclamation"></i> CPF Digitado é Invalido!';
            return false;
        }
    }
    
}

function validarvalorfinanciado() {
    var inputCampo = document.getElementById('valorfinanciado');
    var mensagemErro = document.getElementById('mensagemErroValFinanciado');
    var labelCampo = document.querySelector('label[for="valorfinanciado"]');
    var valorImovel = window.document.getElementById('valorimovel').value;
    var valorFinanciado = inputCampo.value;
    var tipoFinanciamento = document.getElementById('tipoFinanciamento');
    var tipodofinanciamento = tipoFinanciamento.value;
    var MaximoFinaciamento;

    valorImovel = valorImovel.replace("R$ ", "");
    valorImovel = valorImovel.replace(/\./g, "");
    valorImovel = valorImovel.replace(",", ".");

    valorFinanciado = valorFinanciado.replace("R$ ", "");
    valorFinanciado = valorFinanciado.replace(/\./g, "");
    valorFinanciado = valorFinanciado.replace(",", ".");


    if(tipodofinanciamento == "CGI"){
        MaximoFinaciamento = valorImovel*0.6; 
        var textoErro = '<i class="fi fi-ss-exclamation"></i> O valor financiado pode ser no máximo 60% do valor do imovel!';
        console.log(inputCampo.value);

    } else {

        MaximoFinaciamento = valorImovel*0.8;
        var textoErro = '<i class="fi fi-ss-exclamation"></i> O valor financiado pode ser no máximo 80% do valor do imovel!';
        console.log(inputCampo.value);

    }

            // Verifica se o campo está vazio
        if (inputCampo.value.trim() == 'R$ 0,00' || inputCampo.value.trim() == '' ) {
            // Adiciona a classe 'borderdanger' ao input
            inputCampo.classList.add('borderdanger');
            labelCampo.classList.add('colordanger')
            
            // Exibe a mensagem de erro com o ícone
            
            mensagemErro.innerHTML = '<i class="fi fi-ss-exclamation"></i> Digite o valor fianciado';
            
            // Impede o envio do formulário
            return false;
        } else {
        
            if (valorFinanciado > MaximoFinaciamento) {

                // Adiciona a classe 'borderdanger' ao input
                inputCampo.classList.add('borderdanger');
                labelCampo.classList.add('colordanger')
                
                // Exibe a mensagem de erro com o ícone
                
                mensagemErro.innerHTML = textoErro;
                
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

   

    }

function validarTipoFinanciamento() {
    var inputCampo = document.getElementById('tipoFinanciamento');
    var mensagemErro = document.getElementById('mensagemErroValTipoFinanciamento');
    var labelCampo = document.querySelector('label[for="inputFormTipoFinanciamento"]');


    // Verifica se o campo está vazio
    if (inputCampo.value.trim() === 'N/A') {
        // Adiciona a classe 'borderdanger' ao input
        inputCampo.classList.add('borderdanger');
        labelCampo.classList.add('colordanger');
        
        // Exibe a mensagem de erro com o ícone
        mensagemErro.innerHTML = '<i class="fi fi-ss-exclamation"></i> Você precisa selecionar um tipo de financiamento primeiro!';
        
        // Impede o envio do formulário
        return false;
    } else {
        // Remove a classe 'borderdanger' do input
        inputCampo.classList.remove('borderdanger');
        labelCampo.classList.remove('colordanger');

        
        // Limpa a mensagem de erro
        mensagemErro.textContent = '';
        
        // Permite o envio do formulário
        return true;
    }
    
}

function validarEstadoFinanciamento() {
    var inputCampo = document.getElementById('estado');
    var mensagemErro = document.getElementById('mensagemErroValEstado');
    var labelCampo = document.querySelector('label[for="inputFormEstadoFinanciamento"]');


    // Verifica se o campo está vazio
    if (inputCampo.value.trim() === 'N/A') {
        // Adiciona a classe 'borderdanger' ao input
        inputCampo.classList.add('borderdanger');
        labelCampo.classList.add('colordanger');
        
        // Exibe a mensagem de erro com o ícone
        mensagemErro.innerHTML = '<i class="fi fi-ss-exclamation"></i> Você precisa selecionar o estado do imovel primeiro!';
        
        // Impede o envio do formulário
        return false;
    } else {
        // Remove a classe 'borderdanger' do input
        inputCampo.classList.remove('borderdanger');
        labelCampo.classList.remove('colordanger');

        
        // Limpa a mensagem de erro
        mensagemErro.textContent = '';
        
        // Permite o envio do formulário
        return true;
    }
    
}

function validarCidadeFinanciamento() {
    var inputCampo = document.getElementById('opt_de_cidades');
    var mensagemErro = document.getElementById('mensagemErroValCidade');
    var labelCampo = document.querySelector('label[for="inputFormCidadeFinanciamento"]');


    // Verifica se o campo está vazio
    if (inputCampo.value.trim() === 'N/A') {
        // Adiciona a classe 'borderdanger' ao input
        inputCampo.classList.add('borderdanger');
        labelCampo.classList.add('colordanger');
        
        // Exibe a mensagem de erro com o ícone
        mensagemErro.innerHTML = '<i class="fi fi-ss-exclamation"></i> Você precisa selecionar a cidade do imovel primeiro!';
        
        // Impede o envio do formulário
        return false;
    } else {
        // Remove a classe 'borderdanger' do input
        inputCampo.classList.remove('borderdanger');
        labelCampo.classList.remove('colordanger');

        
        // Limpa a mensagem de erro
        mensagemErro.textContent = '';
        
        // Permite o envio do formulário
        return true;
    }
    
}

function validarValorImovel() {
    var inputCampoValorImovel = document.getElementById('valorimovel');
    var mensagemErroValorImovel = document.getElementById('mensagemErroValImovel');
    var labelCampoValorImovel = document.querySelector('label[for="valorimovel"]');

    // Remove espaços em branco antes e depois do valor
    var valorImovel = inputCampoValorImovel.value.trim();

    // Verifica se o campo está vazio
    if (valorImovel === '') {
        // Adiciona a classe 'borderdanger' ao input
        inputCampoValorImovel.classList.add('borderdanger');
        labelCampoValorImovel.classList.add('colordanger');
        
        // Exibe a mensagem de erro com o ícone
        mensagemErroValorImovel.innerHTML = '<i class="fi fi-ss-exclamation"></i> Digite o valor do imóvel!';
        
        // Impede o envio do formulário
        return false;
    } else {
        // Remove a classe 'borderdanger' do input
        console.log("Chegou aqui")
        inputCampoValorImovel.classList.remove('borderdanger');
        labelCampoValorImovel.classList.remove('colordanger');

        mensagemErroValorImovel.textContent = '';
        return true;
    }
}


function validarNomeComprador() {
    var inputCampoName = document.getElementById('inputFormSimulator4');
    var mensagemErroName = document.getElementById('mensagemErroNomeComprador');
    var labelCampoName = document.querySelector('label[for="inputFormSimulator4"]');


    // Verifica se o campo está vazio
    if (inputCampoName.value.trim() === '') {
        // Adiciona a classe 'borderdanger' ao input
        inputCampoName.classList.add('borderdanger');
        labelCampoName.classList.add('colordanger');
        
        // Exibe a mensagem de erro com o ícone
        mensagemErroName.innerHTML = '<i class="fi fi-ss-exclamation"></i> Digite o nome completo do comprador!';
        
        // Impede o envio do formulário
        return false;
    } else {
        // Remove a classe 'borderdanger' do input
        inputCampoName.classList.remove('borderdanger');
        labelCampoName.classList.remove('colordanger');

        
        // Limpa a mensagem de erro
        mensagemErroName.textContent = '';
        
        // Permite o envio do formulário
        return true;
    }
    
}