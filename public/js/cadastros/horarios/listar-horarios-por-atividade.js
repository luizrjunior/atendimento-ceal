function abrirVagasDisponiveisPorHorario(data_atendimento, horario_id) 
{
    $('#carregando').show();
    $('#horario_id').val(horario_id);
    $('#data_atendimento').val(data_atendimento);
    $("#formListarDatasPorHorario").submit();
}