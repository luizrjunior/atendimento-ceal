function validar() 
{
    $('#carregando').show();
}

function ativarDesativarMotivo(motivo_id) 
{
    $('#carregando').show();
    var formURL = top.urlAtivarDesativarMotivo;
    $.ajax({
        type: "POST",
        url: formURL,
        data: {
            _token: $("input[name='_token']").val(),
            motivo_id: motivo_id
        },
        dataType: "json",
        success: function (data) {
            $('#carregando').hide();
            Componentes.modalAlerta(data.textoMsg, atualizarListaMotivo);
        }
    });
}

function atualizarListaMotivo() 
{
    location.href=top.urlListaMotivos;
}
