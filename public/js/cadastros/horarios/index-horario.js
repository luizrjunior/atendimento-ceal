function ativarDesativarHorario(horario_id) 
{
    $('#carregando').show();
    var formURL = top.urlAtivarDesativarHorario;
    $.ajax({
        type: "POST",
        url: formURL,
        data: {
            _token: $("input[name='_token']").val(),
            horario_id: horario_id
        },
        dataType: "json",
        success: function (data) {
            $('#carregando').hide();
            Componentes.modalAlerta(data.textoMsg, listarHorarios);
        }
    });
}

function listarHorarios() 
{
    location.href=top.urlListaHorarios;
}
