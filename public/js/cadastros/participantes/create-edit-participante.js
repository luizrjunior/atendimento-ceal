function validar() {
    $('#carregando').show();
}

function ativarDesativarParticipante(participante_id, horario_id) 
{
    $('#carregando').show();
    var formURL = top.urlAtivarDesativarParticipante;
    $.ajax({
        type: "POST",
        url: formURL,
        data: {
            _token: $("input[name='_token']").val(),
            partic_colaborador_id: participante_id,
            horario_id: horario_id
        },
        dataType: "json",
        success: function (data) {
            $('#carregando').hide();
            Componentes.modalAlerta(data.textoMsg, atualizarListaParticipante);
        }
    });
}

function atualizarListaParticipante() 
{
    location.href=top.urlListaParticipantes;
}
