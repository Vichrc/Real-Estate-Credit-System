document.getElementById('btnDisableInput').addEventListener('click', function(event) {
    event.preventDefault(); // Evita o comportamento padrão do botão (enviar o formulário)

    // Verifica se há inputs desabilitados dentro das áreas de informação
    var disabledInputs = document.querySelectorAll('.infoArea .disabledInput input[disabled], .infoArea .disabledInput select[disabled]');

    if (disabledInputs.length > 0) {
        // Se houver inputs desabilitados, remove o atributo 'disabled' exceto para o input com name=bancoAprovador
        disabledInputs.forEach(function(input) {
            if (input.getAttribute('name') !== 'bancoAprovador' && input.getAttribute('name') !== 'cidadeuser' && input.getAttribute('name') !== 'estadouser' ) {
                input.removeAttribute('disabled');
            }
        });
    } else {
        var disabledInputs = document.querySelectorAll('.infoArea input[disabled], .infoArea select[disabled]');
        disabledInputs.forEach(function(input) {
            input.removeAttribute('disabled');
        });
        event.target.closest('form').submit();
    }
});

function mostrarEsconderConjugue(selectElement) {
    var conjugueDados = document.getElementById('conjugueDados');

    if (selectElement.value === 'casado') {
        conjugueDados.style.display = 'block';
        document.getElementById('nameConjugue').setAttribute('required', 'required');
        document.getElementById('nascimentoConjugue').setAttribute('required', 'required');
        document.getElementById('emailConjugue').setAttribute('required', 'required');
        document.getElementById('telefoneConjugue').setAttribute('required', 'required');
        document.getElementById('rgConjugue').setAttribute('required', 'required');
        document.getElementById('emissorConjugue').setAttribute('required', 'required');
        document.getElementById('dataEmissaoConjugue').setAttribute('required', 'required');
        document.getElementById('cpfConjugue').setAttribute('required', 'required');
        document.getElementById('nomeMaeConjugue').setAttribute('required', 'required');
    } else {
        conjugueDados.style.display = 'none';
        document.getElementById('nameConjugue').removeAttribute('required');
        document.getElementById('nascimentoConjugue').removeAttribute('required');
        document.getElementById('emailConjugue').removeAttribute('required');
        document.getElementById('telefoneConjugue').removeAttribute('required');
        document.getElementById('rgConjugue').removeAttribute('required');
        document.getElementById('emissorConjugue').removeAttribute('required');
        document.getElementById('dataEmissaoConjugue').removeAttribute('required');
        document.getElementById('cpfConjugue').removeAttribute('required');
        document.getElementById('nomeMaeConjugue').removeAttribute('required');
    }
}

function mostrarEsconderRendaConjugue() {
    var checkbox = document.getElementById('compoerenda');
    var compRendaConjugue = document.getElementById('compRendaConjugue');

    if (checkbox.checked) {
        compRendaConjugue.style.display = 'block';
        document.getElementById('profissaoConj').setAttribute('required', 'required');
        document.getElementById('admissaoConj').setAttribute('required', 'required');
        document.getElementById('pisConj').setAttribute('required', 'required');
        document.getElementById('empregadorConj').setAttribute('required', 'required');
        document.getElementById('cnpjEmpregConj').setAttribute('required', 'required');
        document.getElementById('bancoConj').setAttribute('required', 'required');
        document.getElementById('agenciaConj').setAttribute('required', 'required');
        document.getElementById('contaConj').setAttribute('required', 'required');
    } else {
        compRendaConjugue.style.display = 'none';
        document.getElementById('profissaoConj').removeAttribute('required');
        document.getElementById('admissaoConj').removeAttribute('required');
        document.getElementById('pisConj').removeAttribute('required');
        document.getElementById('empregadorConj').removeAttribute('required');
        document.getElementById('cnpjEmpregConj').removeAttribute('required');
        document.getElementById('bancoConj').removeAttribute('required');
        document.getElementById('agenciaConj').removeAttribute('required');
        document.getElementById('contaConj').removeAttribute('required');
    }
}


function toggleDivs() {
    var checkbox = document.getElementById("epf");
    var divProfissao = document.querySelector(".profissaoVendedorPF");
    var divJuridico = document.querySelector(".vendedorJuridico");
    var divFisico = document.querySelector(".vendedorFisico");

    if (checkbox.checked) {
        divJuridico.style.display = "block";
        divFisico.style.display = "none";
        divProfissao.style.display = "none";
        


        /* Tirar Required */
        document.getElementById('nameVendedor').removeAttribute('required');
        document.getElementById('nascimentoVendedor').removeAttribute('required');
        document.getElementById('emailVendedor').removeAttribute('required');
        document.getElementById('telefoneVendedor').removeAttribute('required');
        document.getElementById('rgVendedor').removeAttribute('required');
        document.getElementById('emissorVendedor').removeAttribute('required');
        document.getElementById('dataEmissaoVendedor').removeAttribute('required');
        document.getElementById('cpfVendedor').removeAttribute('required');
        document.getElementById('nomeMaeVendedor').removeAttribute('required');
        document.getElementById('nomepaiVendedor').removeAttribute('required');

        document.getElementById('profissaoVendedor').removeAttribute('required');
        document.getElementById('pisVendedor').removeAttribute('required');
        document.getElementById('dataAdmissãoVendedor').removeAttribute('required');
        document.getElementById('empregadorVendedor').removeAttribute('required');
        document.getElementById('cnpjEmpregadorVendedor').removeAttribute('required');


        /* Colocar Required */
        document.getElementById('nomeVendedorPj').setAttribute('required', 'required');
        document.getElementById('cnpjVendedorPJ').setAttribute('required', 'required');
        document.getElementById('emailVendedorPJ').setAttribute('required', 'required');
        document.getElementById('telefoneVendedorPj').setAttribute('required', 'required');
        document.getElementById('representantePj').setAttribute('required', 'required');
        document.getElementById('cpjRepresentanteCNPJ').setAttribute('required', 'required');
        
    } else {
        divJuridico.style.display = "none";
        divFisico.style.display = "block";
        divProfissao.style.display = "block";

        /* Tirar Required */
        document.getElementById('nomeVendedorPj').removeAttribute('required');
        document.getElementById('cnpjVendedorPJ').removeAttribute('required');
        document.getElementById('emailVendedorPJ').removeAttribute('required');
        document.getElementById('telefoneVendedorPj').removeAttribute('required');
        document.getElementById('representantePj').removeAttribute('required');
        document.getElementById('cpjRepresentanteCNPJ').removeAttribute('required');


        /* Colocar Required */
        document.getElementById('nameVendedor').setAttribute('required', 'required');
        document.getElementById('nascimentoVendedor').setAttribute('required', 'required');
        document.getElementById('emailVendedor').setAttribute('required', 'required');
        document.getElementById('telefoneVendedor').setAttribute('required', 'required');
        document.getElementById('rgVendedor').setAttribute('required', 'required');
        document.getElementById('emissorVendedor').setAttribute('required', 'required');
        document.getElementById('dataEmissaoVendedor').setAttribute('required', 'required');
        document.getElementById('cpfVendedor').setAttribute('required', 'required');
        document.getElementById('nomeMaeVendedor').setAttribute('required', 'required');
        document.getElementById('nomepaiVendedor').setAttribute('required', 'required');

        document.getElementById('profissaoVendedor').setAttribute('required', 'required');
        document.getElementById('pisVendedor').setAttribute('required', 'required');
        document.getElementById('dataAdmissãoVendedor').setAttribute('required', 'required');
        document.getElementById('empregadorVendedor').setAttribute('required', 'required');
        document.getElementById('cnpjEmpregadorVendedor').setAttribute('required', 'required');
    }
}

function mostrarEsconderConjugueVendedor(selectElement) {
    var conjugueDados = document.getElementById('conjugueDadosvendedor');

    if (selectElement.value === 'casado') {
        conjugueDados.style.display = 'block';
        document.getElementById('nameConjugueVendedor').setAttribute('required', 'required');
        document.getElementById('nascimentoConjugueVendedor').setAttribute('required', 'required');
        document.getElementById('emailConjugueVendedor').setAttribute('required', 'required');
        document.getElementById('telefoneConjugueVendedor').setAttribute('required', 'required');
        document.getElementById('rgConjugueVendedor').setAttribute('required', 'required');
        document.getElementById('emissorConjugueVendedor').setAttribute('required', 'required');
        document.getElementById('dataEmissaoConjugueVendedor').setAttribute('required', 'required');
        document.getElementById('cpfConjugueVendedor').setAttribute('required', 'required');
        document.getElementById('nomeMaeConjugueVendedor').setAttribute('required', 'required');
    } else {
        conjugueDados.style.display = 'none';
        document.getElementById('nameConjugueVendedor').removeAttribute('required');
        document.getElementById('nascimentoConjugueVendedor').removeAttribute('required');
        document.getElementById('emailConjugueVendedor').removeAttribute('required');
        document.getElementById('telefoneConjugueVendedor').removeAttribute('required');
        document.getElementById('rgConjugueVendedor').removeAttribute('required');
        document.getElementById('emissorConjugueVendedor').removeAttribute('required');
        document.getElementById('dataEmissaoConjugueVendedor').removeAttribute('required');
        document.getElementById('cpfConjugueVendedor').removeAttribute('required');
        document.getElementById('nomeMaeConjugueVendedor').removeAttribute('required');
    }
}




