function validar() {
    $("#data_atendimento").prop('disabled', false);
    $("#atividade_id").prop('disabled', false);
    $("#horario_id").prop('disabled', false);
}

function marcarNovoAtendimento() {
    validar();
    $('#situacao').val(4);
    var formURL = top.urlMarcarNovoAtendimento;
    $.ajax({
        type: 'POST',
        url: formURL,
        data: { 
            _token: $("input[name='_token']").val(),
            atendimento_id: $("#atendimento_id").val(),
            atividade_id: $("#atividade_id").val(),
            forma_validate: $("#forma_validate").val(),
            forma: $("#forma").val(),
            atendente_id: $("#atendente_id").val() 
        },
        dataType: "json",
        success: function (data) {
            $('input:hidden[name=_method]').val('');
            $('#formAtendimentosUpdate').attr('action', top.urlAbrirNovoAtendimento);
            $("#formAtendimentosUpdate").submit();
        },
        error: function (data) {
            $("#ulErrorEditAtendimento li").remove();

            if (data.responseJSON.forma != undefined) {
                var linha = '<li>' + data.responseJSON.forma[0] + '</li>';
                $("#ulErrorEditAtendimento").append(linha);

                $('#forma').addClass('is-invalid');
                $('#spanFormaAtendimento').html(data.responseJSON.forma[0]);
            } else {
                $('#forma').removeClass('is-invalid');
                $('#spanFormaAtendimento').html('');
            }

            if (data.responseJSON.atendente_id != undefined) {
                var linha = '<li>' + data.responseJSON.atendente_id[0] + '</li>';
                $("#ulErrorEditAtendimento").append(linha);

                $('#atendente_id').addClass('is-invalid');
                $('#spanAtendente').html(data.responseJSON.atendente_id[0]);
            } else {
                $('#atendente_id').removeClass('is-invalid');
                $('#spanAtendente').html('');
            }

            $('#divAlertErrorEditAtendimento').show();
        },
    });

}

function carregarSelectHorarios() {
    var formURL = top.routeCarregarHorarios;
    $.ajax({
        type: 'POST',
        url: formURL,
        data: { 
            _token: $("input[name='_token']").val(),
            atividade_id: $("#atividade_id").val() 
        },
        dataType: "json",
        success: function (data) {
            var dia_semana = ['NULO', 'SEGUNDA-FEIRA', 'TERÇA-FEIRA', 'QUARTA-FEIRA', 'QUINTA-FEIRA', 'SEXTA-FEIRA', 'SÁBADO', 'DOMINGO'];
            var selectbox = $('#horario_id');
            selectbox.find('option').remove();
            $('<option>').val('').text(' -- SELECIONE -- ').appendTo(selectbox);
            $.each(data, function (i, d) {
                var hora_inicio = d.hora_inicio;
                var hora_termino = d.hora_termino;

                var texto = dia_semana[d.dia_semana] + ' de ' + hora_inicio.substr(0, 5) + ' às ' + hora_termino.substr(0, 5) + ' - ' + d.nome + ' - ' + d.numero;
                $('<option>').val(d.id).text(texto).appendTo(selectbox);
            });
            if (top.valorSelectHorario != "") {
                selectbox.val(top.valorSelectHorario);
            }
        }
    });
}

function abrirAbas(expr) {
    $('#divAtendimento').show();
    $('#divMotivos').hide();
    $('#divOrientacoes').hide();
    $('#divObservacoes').hide();
    $('#divHistorico').hide();

    $('#linkAba1').addClass('active');
    $('#linkAba2').removeClass('active');
    $('#linkAba3').removeClass('active');
    $('#linkAba4').removeClass('active');
    $('#linkAba5').removeClass('active');

    if (expr == '2') {
        $('#divMotivos').show();
        $('#divAtendimento').hide();
        $('#divOrientacoes').hide();
        $('#divObservacoes').hide();
        $('#divHistorico').hide();

        $('#linkAba2').addClass('active');
        $('#linkAba1').removeClass('active');
        $('#linkAba3').removeClass('active');
        $('#linkAba4').removeClass('active');
        $('#linkAba5').removeClass('active');
    }
    if (expr == '3') {
        $('#divOrientacoes').show();
        $('#divAtendimento').hide();
        $('#divMotivos').hide();
        $('#divObservacoes').hide();
        $('#divHistorico').hide();

        $('#linkAba3').addClass('active');
        $('#linkAba1').removeClass('active');
        $('#linkAba2').removeClass('active');
        $('#linkAba4').removeClass('active');
        $('#linkAba5').removeClass('active');
    }
    if (expr == '4') {
        $('#divObservacoes').show();
        $('#divAtendimento').hide();
        $('#divMotivos').hide();
        $('#divOrientacoes').hide();
        $('#divHistorico').hide();

        $('#linkAba4').addClass('active');
        $('#linkAba3').removeClass('active');
        $('#linkAba1').removeClass('active');
        $('#linkAba2').removeClass('active');
        $('#linkAba5').removeClass('active');
    }
    if (expr == '5') {
        $('#divHistorico').show();
        $('#divObservacoes').hide();
        $('#divAtendimento').hide();
        $('#divMotivos').hide();
        $('#divOrientacoes').hide();

        $('#linkAba5').addClass('active');
        $('#linkAba4').removeClass('active');
        $('#linkAba3').removeClass('active');
        $('#linkAba1').removeClass('active');
        $('#linkAba2').removeClass('active');
    }
}

$('#btnCloseAlertErrorEditAtendimento').click(function () {
    $('#divAlertErrorEditAtendimento').hide();
});

$(document).ready(function () {
    $("#data_atendimento").mask("99/99/9999");
    $('#data_atendimento').datepicker({	
        format: "dd/mm/yyyy",	
        language: "pt-BR"
    });

    $("#atividade_id").change(function () {
        carregarSelectHorarios();
    });

    if (top.valorSelectAtividade != "") {
        carregarSelectHorarios();
    }

    $("#checkTodos").click(function () {
        if ( $(this).is(':checked') ){
            $('.permissao').attr("checked", true);
        }else{
            $('.permissao').attr("checked", false);
        }
    });

    $("#checkTodos2").click(function () {
        if ( $(this).is(':checked') ){
            $('.permissao2').attr("checked", true);
        }else{
            $('.permissao2').attr("checked", false);
        }
    });
    $('#divAlertErrorEditAtendimento').hide();

});