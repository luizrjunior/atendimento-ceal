$(document).ready(function () {
    $("#cpf").mask("999.999.999-99");
    $("#nascimento").mask("99/99/9999");
    $('#nascimento').datepicker({	
        format: "dd/mm/yyyy",	
        language: "pt-BR"
    });
    $("#telefone").mask("(99) 99999-9999");
});