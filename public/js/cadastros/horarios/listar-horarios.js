function abrirAgendamentos(agendamento_id, horario_id) 
{
    $('#carregando').show();
    $('#horario_id').val(horario_id);
    $('#agendamento_id').val(agendamento_id);
    $("#formListarHorarios").submit();
}