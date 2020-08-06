function validar() 
{
    $('#carregando').show();
}

function ativarDesativarAgendamento(agendamento_id) 
{
    $('#carregando').show();
    var formURL = top.urlAtivarDesativarAgendamento;
    $.ajax({
        type: "POST",
        url: formURL,
        data: {
            _token: $("input[name='_token']").val(),
            agendamento_id: agendamento_id
        },
        dataType: "json",
        success: function (data) {
            $('#carregando').hide();
            Componentes.modalAlerta(data.textoMsg, atualizarListaAgendamento);
        }
    });
}

function atualizarListaAgendamento() 
{
    location.href=top.urlListaAgendamentos;
}
