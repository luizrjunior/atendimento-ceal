function abrirAgendamentos(horario_id) 
{
    $('#carregando').show();
    $('#horario_id').val(horario_id);
    $("#formListarHorarios").submit();
}