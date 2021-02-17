<div class="card-header">
    Histórico de Atendimentos
    <a href="{{ url('atendimentos') }}" class="float-right">
        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-left-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
            <path fill-rule="evenodd" d="M8.354 11.354a.5.5 0 0 0 0-.708L5.707 8l2.647-2.646a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708 0z"/>
            <path fill-rule="evenodd" d="M11.5 8a.5.5 0 0 0-.5-.5H6a.5.5 0 0 0 0 1h5a.5.5 0 0 0 .5-.5z"/>
        </svg>
        Voltar
    </a>
</div>
<div class="card-body">

    <div class="DocumentList">
        <table class="table table-striped">
            <thead>
                <tr>
                    <td><b>Data</b></td>
                    <td><b>Atividade</b></td>
                    <td><b>Dia e Horário</b></td>
                    <td><b>Situação</b></td>
                </tr>
            </thead>
            <tbody>

                @php
                $historicoController = new \App\Http\Controllers\Atendimentos\AtendimentoController();
                $historicos = $historicoController->historico($atendimento->paciente_id);
                @endphp

                @foreach($historicos as $historico)
                <tr>
                    <td><a href="{{ route('atendimentos.edit', $historico->id) }}">{{date('d/m/Y', strtotime($historico->data_atendimento))}}</a></td>
                    <td><a href="{{ route('atendimentos.edit', $historico->id) }}">{{$historico->horario->atividade->nome}}</a></td>
                    <td><a href="{{ route('atendimentos.edit', $historico->id) }}">{{$arrDiaSemana[$historico->horario->dia_semana]}} - {{substr($historico->horario->hora_inicio, 0, -3)}} às {{substr($historico->horario->hora_termino, 0, -3)}}</a></td>
                    <td>
                        <span class="badge badge-{{$bgColor[$historico->situacao]}}"
                            data-toggle="tooltip" title="{{$arrSituacao[$historico->situacao]}}">
                            {{$arrSituacao[$historico->situacao]}}
                        </span>
                    </td>
                </tr>
                @endforeach
                @if (count($historicos) == 0)
                <tr>
                    <td colspan="7">Nenhum registro encontrado!</td>
                </tr>
                @endif

            </tbody>
        </table>
    </div>

</div>
