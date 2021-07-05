function validar() {
    $('#carregando').show();
}

function carregarPessoaCPF() {
    if ($('#cpf').val() != "") {
        $('#carregando').show();
        var formURL = top.routeCarregarPessoaCPF;
        $.ajax({
            type: "POST",
            url: formURL,
            data: {
                _token: $("input[name='_token']").val(),
                cpf: $('#cpf').val()
            },
            dataType: "json",
            success: function (data) {
                if (data.id == undefined) {
                    Componentes.modalAlerta("Nenhum registro encontrado!&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", null);
                }
                if (data.id != undefined) {
                    var nascimento = formatDate(data.nascimento, 'pt-br');
                    $('#pessoa_id').val(data.id);
                    $('#cpf').val(data.cpf);
                    $('#nome').val(data.nome);
                    $("#nascimento").val(nascimento);
                    $("#sexo").val(data.sexo);
                    $('#telefone').val(data.telefone);
                    $('#profissao').val(data.profissao);
                    $('#socio').val(data.socio);
                    $("#bairro").val(data.bairro);
                }
                $('#carregando').hide();
            }
        });
    }
}

function formatDate(data, formato) {
    if (formato == 'pt-br') {
        return String(data.substr(0, 10).split('-').reverse().join('/'));
    } else {
        return (data.substr(0, 10).split('/').reverse().join('-'));
    }
}

function limparFormulario() {
    $('#carregando').show();
    location.href='create';
}

function selecionarPessoaParaAtendimento() {
    $('#carregando').show();
    location.href=top.routeSelecionarPessoaAtendimento;
}

$(document).ready(function () {
    $("#cpf").mask("999.999.999-99");
    $("#nascimento").mask("99/99/9999");
    $('#nascimento').datepicker({
        format: "dd/mm/yyyy",
        language: "pt-BR"
    });
    $("#telefone").mask("(99) 99999-9999");

    $("#cpf").blur(function () {
        carregarPessoaCPF();
    });
});
