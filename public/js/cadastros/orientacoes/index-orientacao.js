function validar() 
{
    $('#carregando').show();
}

function ativarDesativarOrientacao(orientacao_id) 
{
    $('#carregando').show();
    var formURL = top.urlAtivarDesativarOrientacao;
    $.ajax({
        type: "POST",
        url: formURL,
        data: {
            _token: $("input[name='_token']").val(),
            orientacao_id: orientacao_id
        },
        dataType: "json",
        success: function (data) {
            $('#carregando').hide();
            Componentes.modalAlerta(data.textoMsg, atualizarListaOrientacao);
        }
    });
}

function atualizarListaOrientacao() 
{
    location.href=top.urlListaOrientacoes;
}
