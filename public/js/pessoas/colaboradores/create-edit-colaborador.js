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
                    $('#pessoa_id').val('');
                    $('#cpf').val('');
                    $('#nome').val('');
                    $("#nascimento").val('');
                    $("#sexo").val('');
                    $('#telefone').val('');
                    $('#profissao').val('');
                    $('#socio').val('');
                    $("#bairro").val('');
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

$(document).ready(function () {
    $("#cpf").change(function () {
        carregarPessoaCPF();
    });

    $("#checkTodos").click(function () {
        if ( $(this).is(':checked') ){
            $('.funcao').attr("checked", true);
        }else{
            $('.funcao').attr("checked", false);
        }
    });

    $("#nome").prop('disabled', true);
    $("#nascimento").prop('disabled', true);
    $("#sexo").prop('disabled', true);
    $("#telefone").prop('disabled', true);
    $("#profissao").prop('disabled', true);
    $("#socio").prop('disabled', true);
    $("#bairro").prop('disabled', true);
});