<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Comprovante de Pagamento</title>
    <style>
        @page { margin: 20mm; }
        body { font-family: 'DejaVu Sans', sans-serif; color: #1a1a2e; font-size: 12px; }
        .header { text-align: center; border-bottom: 3px solid #2563eb; padding-bottom: 15px; margin-bottom: 25px; }
        .header h1 { color: #2563eb; font-size: 26px; margin: 0 0 5px 0; text-transform: uppercase; letter-spacing: 2px; }
        .header p { color: #64748b; font-size: 14px; margin: 0; }
        .title { text-align: center; font-size: 20px; color: #1e293b; margin-bottom: 25px; padding: 10px; background: #f1f5f9; border-radius: 6px; }
        .info-box { border: 2px solid #e2e8f0; border-radius: 8px; padding: 18px 22px; margin-bottom: 25px; background: #fafbfc; }
        .info-box table { width: 100%; border-collapse: collapse; }
        .info-box td { padding: 6px 8px; vertical-align: top; }
        .info-box .label { font-weight: 700; color: #475569; width: 140px; }
        .info-box .value { color: #0f172a; }
        .info-box .divider td { padding: 0; height: 8px; }
        .status-badge { display: inline-block; padding: 3px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; background: #dcfce7; color: #166534; }
        .section-title { font-size: 16px; color: #2563eb; border-bottom: 2px solid #2563eb; padding-bottom: 6px; margin: 25px 0 15px 0; }
        .team-title { font-size: 15px; color: #fff; background: #2563eb; padding: 8px 14px; border-radius: 6px; margin: 20px 0 8px 0; }
        .mod-title { font-size: 13px; font-weight: 700; color: #334155; background: #f1f5f9; padding: 6px 14px; border-radius: 6px; margin: 10px 0 6px 0; }
        table.atletas { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        table.atletas th { background: #2563eb; color: #fff; padding: 7px 12px; text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; }
        table.atletas td { padding: 6px 12px; border-bottom: 1px solid #e2e8f0; font-size: 12px; }
        table.atletas tr:nth-child(even) td { background: #f8fafc; }
        .footer { text-align: center; color: #94a3b8; font-size: 10px; margin-top: 30px; padding-top: 15px; border-top: 1px solid #e2e8f0; }
        .total-box { text-align: right; font-size: 16px; font-weight: 700; color: #166534; padding: 10px 14px; background: #dcfce7; border-radius: 6px; margin-top: 10px; }
        .empty-msg { color: #94a3b8; text-align: center; padding: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ config('app.name') }}</h1>
        <p>Encontro de Jovens com Cristo</p>
    </div>

    <div class="title">COMPROVANTE DE PAGAMENTO</div>

    <div class="info-box">
        <table>
            <tr>
                <td class="label">Responsavel:</td>
                <td class="value">{{ $user->name }}</td>
            </tr>
            <tr>
                <td class="label">Paroquia:</td>
                <td class="value">{{ $user->paroquia ? $user->paroquia->name . ' - ' . $user->paroquia->city : '-' }}</td>
            </tr>
            <tr class="divider"><td colspan="2"></td></tr>
            <tr>
                <td class="label">Inscricao:</td>
                <td class="value">#{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</td>
            </tr>
            <tr>
                <td class="label">Valor Pago:</td>
                <td class="value">R$ {{ number_format($total, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="label">Status:</td>
                <td class="value"><span class="status-badge">Pago</span></td>
            </tr>
        </table>
    </div>

    <div class="section-title">Participantes por Time</div>

    @forelse($teams as $team)
        <div class="team-title">{{ $team['team_name'] }} ({{ $team['atletas']->count() }} atleta(s))</div>

        @forelse($team['modalidades'] as $mod => $modAtletas)
            <div class="mod-title">{{ ucfirst($mod) }} ({{ count($modAtletas) }})</div>
            <table class="atletas">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Nome</th>
                        <th style="width: 80px;">Idade</th>
                        <th style="width: 80px;">Pagamento</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($modAtletas as $i => $atleta)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $atleta->nome }}{{ $atleta->conhecido_como ? ' (' . $atleta->conhecido_como . ')' : '' }}</td>
                            <td>{{ $atleta->data_nascimento ? \Carbon\Carbon::parse($atleta->data_nascimento)->age : '-' }}</td>
                            <td>Pago</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @empty
            <p class="empty-msg">Nenhum participante neste time.</p>
        @endforelse
    @empty
        <p class="empty-msg">Nenhum participante com pagamento confirmado.</p>
    @endforelse

    @if($total > 0)
        <div class="total-box">
            Total: R$ {{ number_format($total, 2, ',', '.') }}
        </div>
    @endif

    <div class="footer">
        EJC - Encontro de Jovens com Cristo &bull; Gerado em {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>
