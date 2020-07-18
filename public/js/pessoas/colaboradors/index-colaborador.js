function validar() 
{
    $('#carregando').show();
}

function ativarDesativarColaborador(colaborador_id) 
{
    $('#carregando').show();
    var formURL = top.urlAtivarDesativarColaborador;
    $.ajax({
        type: "POST",
        url: formURL,
        data: {
            _token: $("input[name='_token']").val(),
            colaborador_id: colaborador_id
        },
        dataType: "json",
        success: function (data) {
            $('#carregando').hide();
            Componentes.modalAlerta(data.textoMsg, atualizarListaColaborador);
        }
    });
}

function atualizarListaColaborador() 
{
    location.href=top.urlListaColaboradors;
}
