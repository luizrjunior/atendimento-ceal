function validar() 
{
    $('#carregando').show();
}

function ativarDesativarFuncao(funcao_id) 
{
    $('#carregando').show();
    var formURL = top.urlAtivarDesativarFuncao;
    $.ajax({
        type: "POST",
        url: formURL,
        data: {
            _token: $("input[name='_token']").val(),
            funcao_id: funcao_id
        },
        dataType: "json",
        success: function (data) {
            $('#carregando').hide();
            Componentes.modalAlerta(data.textoMsg, atualizarListaFuncao);
        }
    });
}

function atualizarListaFuncao() 
{
    location.href=top.urlListaFuncoes;
}
