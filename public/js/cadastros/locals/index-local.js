function validar() 
{
    $('#carregando').show();
}

function ativarDesativarLocal(local_id) 
{
    $('#carregando').show();
    var formURL = top.urlAtivarDesativarLocal;
    $.ajax({
        type: "POST",
        url: formURL,
        data: {
            _token: $("input[name='_token']").val(),
            local_id: local_id
        },
        dataType: "json",
        success: function (data) {
            $('#carregando').hide();
            Componentes.modalAlerta(data.textoMsg, atualizarListaLocal);
        }
    });
}

function atualizarListaLocal() 
{
    location.href=top.urlListaLocals;
}
