function abrirHorarios(atividade_id) 
{
    $('#carregando').show();
    $('#atividade_id').val(atividade_id);
    $("#formListarAtividades").submit();
}