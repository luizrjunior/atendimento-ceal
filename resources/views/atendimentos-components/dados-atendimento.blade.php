<h4>
    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M10.146 4.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L12.793 8l-2.647-2.646a.5.5 0 0 1 0-.708z"/>
        <path fill-rule="evenodd" d="M2 8a.5.5 0 0 1 .5-.5H13a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 8z"/>
    </svg>
    {{$horario->atividade->nome}}
</h4>
<h5>
    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-return-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M10.146 5.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L12.793 9l-2.647-2.646a.5.5 0 0 1 0-.708z"/>
        <path fill-rule="evenodd" d="M3 2.5a.5.5 0 0 0-.5.5v4A2.5 2.5 0 0 0 5 9.5h8.5a.5.5 0 0 0 0-1H5A1.5 1.5 0 0 1 3.5 7V3a.5.5 0 0 0-.5-.5z"/>
    </svg>
    Data: {{$data_atendimento}}
</h5>
<h5>
    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-return-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M10.146 5.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L12.793 9l-2.647-2.646a.5.5 0 0 1 0-.708z"/>
        <path fill-rule="evenodd" d="M3 2.5a.5.5 0 0 0-.5.5v4A2.5 2.5 0 0 0 5 9.5h8.5a.5.5 0 0 0 0-1H5A1.5 1.5 0 0 1 3.5 7V3a.5.5 0 0 0-.5-.5z"/>
    </svg>
    Dia: {{$arrDiaSemana[$horario->dia_semana]}}
</h5>
<h5>
    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-return-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M10.146 5.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L12.793 9l-2.647-2.646a.5.5 0 0 1 0-.708z"/>
        <path fill-rule="evenodd" d="M3 2.5a.5.5 0 0 0-.5.5v4A2.5 2.5 0 0 0 5 9.5h8.5a.5.5 0 0 0 0-1H5A1.5 1.5 0 0 1 3.5 7V3a.5.5 0 0 0-.5-.5z"/>
    </svg>
    De {{substr($horario->hora_inicio, 0, -3)}} horas às {{substr($horario->hora_termino, 0, -3)}} horas
</h5>
<h5>
    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-return-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M10.146 5.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L12.793 9l-2.647-2.646a.5.5 0 0 1 0-.708z"/>
        <path fill-rule="evenodd" d="M3 2.5a.5.5 0 0 0-.5.5v4A2.5 2.5 0 0 0 5 9.5h8.5a.5.5 0 0 0 0-1H5A1.5 1.5 0 0 1 3.5 7V3a.5.5 0 0 0-.5-.5z"/>
    </svg>
    Local: {{$horario->local->nome}} - {{$horario->local->numero}}
</h5>
<h5>
    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-return-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M10.146 5.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L12.793 9l-2.647-2.646a.5.5 0 0 1 0-.708z"/>
        <path fill-rule="evenodd" d="M3 2.5a.5.5 0 0 0-.5.5v4A2.5 2.5 0 0 0 5 9.5h8.5a.5.5 0 0 0 0-1H5A1.5 1.5 0 0 1 3.5 7V3a.5.5 0 0 0-.5-.5z"/>
    </svg>
    Atendido: {{ $paciente->nome }}
</h5>