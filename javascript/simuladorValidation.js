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
const img3 = document.querySelector('.incognta3');
const img4 = document.querySelector('.incognta4');
const img5 = document.querySelector('.incognta5');

img.addEventListener('mouseover', function() {
    // Altera o atributo 'src' da imagem quando o mouse passa sobre ela
    img.src = 'css/img/incognta01.png';
});

img.addEventListener('mouseleave', function() {
    img.src = 'css/img/incognta.png';
});

img2.addEventListener('mouseover', function() {
    // Altera o atributo 'src' da imagem quando o mouse passa sobre ela
    img2.src = 'css/img/incognta01.png';
});

img2.addEventListener('mouseleave', function() {
    img2.src = 'css/img/incognta.png';
});

img3.addEventListener('mouseover', function() {
    // Altera o atributo 'src' da imagem quando o mouse passa sobre ela
    img3.src = 'css/img/incognta01.png';
});

img3.addEventListener('mouseleave', function() {
    img3.src = 'css/img/incognta.png';
});

img4.addEventListener('mouseover', function() {
    // Altera o atributo 'src' da imagem quando o mouse passa sobre ela
    img4.src = 'css/img/incognta01.png';
});

img4.addEventListener('mouseleave', function() {
    img4.src = 'css/img/incognta.png';
});

img5.addEventListener('mouseover', function() {
    // Altera o atributo 'src' da imagem quando o mouse passa sobre ela
    img5.src = 'css/img/incognta01.png';
});

img5.addEventListener('mouseleave', function() {
    img5.src = 'css/img/incognta.png';
});

//<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< Final Imagens Duvida <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<

    // Obtém os elementos de input
    var rangeInput = document.getElementById('rangePrazo');
    var numberInput = document.getElementById('numberPrazo');


    rangeInput.addEventListener('input', function() {
        // Define o valor do input do tipo número para ser igual ao valor do input do tipo range
        numberInput.value = this.value;
    });

    // Define um evento de input no input do tipo número
    numberInput.addEventListener('input', function() {
        // Verifica se o valor inserido no input do tipo número está dentro dos limites do input do tipo range
        if (this.value < parseInt(rangeInput.min)) {
            // Se estiver abaixo do limite mínimo, define-o como o valor mínimo do input do tipo range
            this.value = rangeInput.min;
        } else if (this.value > parseInt(rangeInput.max)) {
            // Se estiver acima do limite máximo, define-o como o valor máximo do input do tipo range
            this.value = rangeInput.max;
        }
        // Define o valor do input do tipo range para ser igual ao valor do input do tipo número
        rangeInput.value = this.value;
    });



function handleFormSubmit() {
    var simulator = document.getElementById("simulatorarea");

    // Chame a função que já existe no onSubmit
    var resultadoValidacao = validarForm();

    // Se a validação for bem-sucedida, chame a função loadingRegister
    if (resultadoValidacao) {
        console.log("Deu certo")
        simulator.style.display = "none";
    } else {
        console.log("Deu Erro")
    }

    // Retorne o resultado da validação (pode ajustar conforme necessário)
    return resultadoValidacao;
}


function validarForm() {
    var isValidValFin= validarvalorfinanciado();
    var isValidTypeFin = validarTipoFinanciamento();
    var isValidEstFin = validarEstadoFinanciamento();
    var isValidCidFin = validarCidadeFinanciamento();
    var isValidName = validarNomeComprador();
    var isValidDataNasc = validarNascimento();
    var isValidCPF = validarInputCPF();

    // Retorna true apenas se as validações forem verdadeiras
    return isValidValFin && isValidTypeFin && isValidEstFin && isValidCidFin && isValidName && isValidDataNasc && isValidCPF;
}

// Define a função para verificar o financiamento
function verificarFinanciamento() {
    var tipoFinanciamento = document.getElementById('tipoFinanciamento');
    var valorImovel = document.getElementById('valorimovel');
    var valorFinanciado = document.getElementById('valorfinanciado');
}

// Chama a função verificarFinanciamento() quando a página é carregada

// Adiciona um evento onchange ao elemento select
document.getElementById('tipoFinanciamento').addEventListener('change', verificarFinanciamento);
document.getElementById('tipoFinanciamento').addEventListener('change', alteraRange);
document.getElementById('tipoFinanciamento').addEventListener('change', validarTipoFinanciamento);

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

function validarNascimento() {
    var inputCampoData = document.getElementById('inputFormSimulator5');
    var inputCampoMeses = document.getElementById('numberPrazo');
    var mensagemErroData = document.getElementById('mensagemErroDataNascimento');
    var labelCampoData = document.querySelector('label[for="inputFormSimulator5"]');


    // Verifica se o campo está vazio
    if (inputCampoData.value.trim() === '') {
        // Adiciona a classe 'borderdanger' ao input
        inputCampoData.classList.add('borderdanger');
        labelCampoData.classList.add('colordanger');
        
        // Exibe a mensagem de erro com o ícone
        mensagemErroData.innerHTML = '<i class="fi fi-ss-exclamation"></i> Digite a data de nascimento do comprador!';
        
        // Impede o envio do formulário
        return false;
    } else {
        var dataAniversarioComp = new Date(inputCampoData.value);
        var anoNascimento = dataAniversarioComp.getFullYear();
        var dataAtual = new Date();
        var anoAtual = dataAtual.getFullYear();
        var idadeComprador = anoAtual - anoNascimento;
        var AnosFinanciamento = inputCampoMeses.value / 12;
        var idadeFinalFinanciamento = idadeComprador + AnosFinanciamento; 

        
        if (idadeFinalFinanciamento <= 80.5){
            // Remove a classe 'borderdanger' do input
            console.log(idadeFinalFinanciamento);
            inputCampoData.classList.remove('borderdanger');
            labelCampoData.classList.remove('colordanger');

            
            // Limpa a mensagem de erro
            mensagemErroData.textContent = '';
            
            // Permite o envio do formulário
            return true;
        } else {
        // Adiciona a classe 'borderdanger' ao input
        inputCampoData.classList.add('borderdanger');
        labelCampoData.classList.add('colordanger');
        
        // Exibe a mensagem de erro com o ícone
        mensagemErroData.innerHTML = '<i class="fi fi-ss-exclamation"></i> A idade do comprador deve ser menor que 80 anos e 6 meses ao final do financiamento! ';
        
        // Impede o envio do formulário
        return false;
        }
    }
    
}

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

function alteraRange(){
    var inputTypeFin = window.document.getElementById('tipoFinanciamento');
    var inputRange = window.document.getElementById('rangePrazo');
    var inputMes = window.document.getElementById('numberPrazo');

    if(inputTypeFin.value == "CGI"){
        inputRange.max = 240
        inputMes.value = inputRange.value;
    
    } else {
        inputRange.max = 420
        inputMes.value = inputRange.value;
    }
}


