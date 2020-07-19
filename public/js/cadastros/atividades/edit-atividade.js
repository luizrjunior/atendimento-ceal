function editDiaHoraAtividade(dia_hora_atividade_id) 
{
    $('#carregando').show();
    var formURL = top.routeEditDiaHoraAtividadeJson;
    $.ajax({
        type: 'POST',
        url: formURL,
        data: { 
            _token: $("input[name='_token']").val(),
            dia_hora_atividade_id: dia_hora_atividade_id 
        },
        dataType: "json",
        success: function (data) {
            $('#carregando').hide();
            $('#dia_hora_atividade_id').val(data.id);
            $('#dia_semana').val(data.dia_semana);
            $('#hora_inicio').val(data.hora_inicio);
            $('#hora_termino').val(data.hora_termino);
            
            $('#btnAdEdDiaHora').html('Atualizar');
            $('#btnCancelDiaHora').show();
        }
    });
}

function ativarDesativarDiaHoraAtividade(dia_hora_atividade_id) 
{
    $('#carregando').show();
    var formURL = top.urlAtivarDesativarDiaHoraAtividade;
    $.ajax({
        type: "POST",
        url: formURL,
        data: {
            _token: $("input[name='_token']").val(),
            dia_hora_atividade_id: dia_hora_atividade_id
        },
        dataType: "json",
        success: function (data) {
            $('#carregando').hide();
            Componentes.modalAlerta(data.textoMsg, editarAtividade);
        }
    });
}

function editarAtividade() 
{
    location.href=top.urlEditAtividade;
}

$(document).ready(function () {
    $("#hora_inicio").mask("99:99");
    $("#hora_termino").mask("99:99");
    
    $("#role_id").change(function () {
        loadPermissionsRoleJson();
    });
});

