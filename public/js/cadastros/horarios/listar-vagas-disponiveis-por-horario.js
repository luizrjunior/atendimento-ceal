function abrirAtendimento(horario_id, situacao, data_atendimento) 
{
    $('#carregando').show();
    $('#horario_id').val(horario_id);
    $('#situacao').val(situacao);
    $('#data_atendimento').val(data_atendimento);
    $("#formListarVagasDisponiveisPorHorario").submit();
}