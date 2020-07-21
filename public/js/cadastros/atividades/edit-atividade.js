function abrirCard(card) {
    $('#divCardAddRoleUser').hide();
    $('#divCardListRolesUser').show();
    if (card == 2) {
        $('#divCardListRolesUser').hide();
        $('#divCardAddRoleUser').show();
    }
}

function editAtividadeTemDiaHora(atividade_tem_dia_hora_id) 
{
    $('#carregando').show();
    var formURL = top.routeEditAtividadeTemDiaHoraJson;
    $.ajax({
        type: 'POST',
        url: formURL,
        data: { 
            _token: $("input[name='_token']").val(),
            atividade_tem_dia_hora_id: atividade_tem_dia_hora_id 
        },
        dataType: "json",
        success: function (data) {
            abrirCard(2);
            $('#carregando').hide();
            $('#atividade_tem_dia_hora_id').val(data.id);
            $('#dia_semana').val(data.dia_semana);
            $('#hora_inicio').val(data.hora_inicio);
            $('#hora_termino').val(data.hora_termino);
            
            $('#btnAdEdDiaHora').html('Atualizar');
            $('#btnCancelDiaHora').show();
        }
    });
}

function ativarDesativarAtividadeTemDiaHora(atividade_tem_dia_hora_id) 
{
    $('#carregando').show();
    var formURL = top.urlAtivarDesativarAtividadeTemDiaHora;
    $.ajax({
        type: "POST",
        url: formURL,
        data: {
            _token: $("input[name='_token']").val(),
            atividade_tem_dia_hora_id: atividade_tem_dia_hora_id
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
    abrirCard(1);
});

