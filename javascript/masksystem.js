$(".telefone").mask("(00) 00000-0009");

$("#cpfMask, .cpfMask").mask("999.999.999-99");

$("#cnpjMAsk, .cnpjMAsk").mask("99.999.999/9999-99");

$("#cepInput, .cepInput").mask("99990-999");

$("#pisInput, .pisInput").mask("999.99999.99.0");



var options = {
    onKeyPress: function (cpf, ev, el, op) {
        var masks = ['000.000.000-000', '00.000.000/0000-00'];
        $('.cpfOuCnpj').mask((cpf.length > 14) ? masks[1] : masks[0], op);
    }
}

$('.cpfOuCnpj').length > 11 ? $('.cpfOuCnpj').mask('00.000.000/0000-00', options) : $('.cpfOuCnpj').mask('000.000.000-00#', options);



function submitform() {
    const formulario = document.getElementById("form")
    console.log(formulario)
    formulario.submit();
}