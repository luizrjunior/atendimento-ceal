function validar() 
{
    $('#carregando').show();
}

function ativarDesativarAtividade(atividade_id) 
{
    $('#carregando').show();
    var formURL = top.urlAtivarDesativarAtividade;
    $.ajax({
        type: "POST",
        url: formURL,
        data: {
            _token: $("input[name='_token']").val(),
            atividade_id: atividade_id
        },
        dataType: "json",
        success: function (data) {
            $('#carregando').hide();
            Componentes.modalAlerta(data.textoMsg, atualizarListaAtividade);
        }
    });
}

function atualizarListaAtividade() 
{
    location.href=top.urlListaAtividades;
}
