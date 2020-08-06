function abrirAtendimento(agendamento_id, situacao, forma) 
{
    $('#carregando').show();
    $('#agendamento_id').val(agendamento_id);
    $('#situacao').val(situacao);
    $('#forma').val(forma);
    $("#formListarAgendamentos").submit();
}