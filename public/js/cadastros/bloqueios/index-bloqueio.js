function validar()
{
    $('#carregando').show();
}

function ativarDesativarBloqueio(bloqueio_id)
{
    $('#carregando').show();
    var formURL = top.urlAtivarDesativarBloqueio;
    $.ajax({
        type: "POST",
        url: formURL,
        data: {
            _token: $("input[name='_token']").val(),
            bloqueio_id: bloqueio_id
        },
        dataType: "json",
        success: function (data) {
            $('#carregando').hide();
            Componentes.modalAlerta(data.textoMsg, atualizarListaBloqueio);
        }
    });
}

function atualizarListaBloqueio()
{
    location.href=top.urlListaBloqueios;
}
