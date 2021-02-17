function validar() {
    $('#carregando').show();
    $("#horario_id").prop('disabled', false);
    $("#data_atendimento").prop('disabled', false);
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

});