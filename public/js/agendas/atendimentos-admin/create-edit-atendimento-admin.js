function validar() {
    $('#carregando').show();
    $("#forma").prop('disabled', false);
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

                var texto = dia_semana[d.dia_semana] + ' de ' + hora_inicio.substr(0, 5) + ' às ' + hora_termino.substr(0, 5) + ' - ' + d.numero + ' - ' + d.nome;
                $('<option>').val(d.id).text(texto).appendTo(selectbox);
            });
            if (top.valorSelectHorario != "") {
                selectbox.val(top.valorSelectHorario);
            }
        }
    });
}

function abrirAbas(expr) {
    $('#divMotivos').show();
    $('#divOrientacoes').hide();

    $('#linkAba1').addClass('active');
    $('#linkAba2').removeClass('active');

    if (expr == '1') {
        $('#divMotivos').hide();
        $('#divOrientacoes').show();

        $('#linkAba2').addClass('active');
        $('#linkAba1').removeClass('active');
    }
}

$(document).ready(function () {
    $("#data").mask("99/99/9999");
    $('#data').datepicker({	
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

});