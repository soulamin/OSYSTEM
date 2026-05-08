<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>OS #{{ $order->number }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111; }
        table { width: 100%; border-collapse: collapse; }
        .header { border: 1px solid #0b2f6a; background: #0b3d91; color: #fff; padding: 14px 16px; margin-bottom: 12px; }
        .header-title { font-size: 18px; font-weight: bold; letter-spacing: .3px; }
        .header-sub { font-size: 12px; opacity: .95; margin-top: 2px; }
        .badge-dot { display: inline-block; width: 10px; height: 10px; border-radius: 999px; background: #1ea7ff; margin-right: 8px; vertical-align: middle; }
        .box { border: 1px solid #d9d9d9; padding: 10px 12px; margin-bottom: 10px; }
        .box-title { font-weight: bold; margin-bottom: 6px; }
        .muted { color: #666; }
        .field { width: 100%; }
        .field td { padding: 4px 0; vertical-align: top; }
        .label { width: 90px; color: #333; font-weight: bold; }
        .value { border-bottom: 1px solid #bbb; padding-bottom: 2px; }
        .textblock { min-height: 70px; border: 1px solid #e1e1e1; padding: 8px; }
        .textblock.small { min-height: 56px; }
        .sign-grid td { width: 50%; vertical-align: top; }
        .sign-box { border: 1px solid #e1e1e1; padding: 10px; min-height: 110px; }
        .sign-title { font-weight: bold; margin-bottom: 8px; }
        .sign-line { border-top: 1px solid #111; margin-top: 70px; padding-top: 4px; color: #333; }
        .sign-img { text-align: center; }
        .sign-img img { max-width: 100%; max-height: 140px; }
    </style>
</head>
<body>
    @php
        $safeNumber = str_pad((string) $order->number, 6, '0', STR_PAD_LEFT);
        $clientName = $order->client?->name ?: '';
        $clientPhone = $order->client?->phone ?: '';
        $clientEmail = $order->client?->email ?: '';
        $technicianName = $order->responsible?->name ?: '';
        $problemText = trim((string) ($order->notes ?? ''));
        $solutionText = trim((string) ($order->solution ?? ''));
        $finalDate = $order->closed_at ? optional($order->closed_at)->format('d/m/Y') : '';
    @endphp

    <div class="header">
        <div class="header-title"><span class="badge-dot"></span>ORDEM DE SERVIÇO</div>
        <div class="header-sub">Nº da Ordem: <b>{{ $safeNumber }}</b></div>
    </div>

    <div class="box">
        <div class="box-title">Cliente</div>
        <table class="field">
            <tr>
                <td class="label">Nome:</td>
                <td class="value">{{ $clientName ?: ' ' }}</td>
            </tr>
            <tr>
                <td class="label">Telefone:</td>
                <td class="value">{{ $clientPhone ?: ' ' }}</td>
            </tr>
            <tr>
                <td class="label">Email:</td>
                <td class="value">{{ $clientEmail ?: ' ' }}</td>
            </tr>
        </table>
    </div>

    <div class="box">
        <div class="box-title">Descrição do Problema</div>
        <div class="textblock">@if($problemText !== ''){!! nl2br(e($problemText)) !!}@else&nbsp;@endif</div>
    </div>

    <div class="box">
        <div class="box-title">Solução Realizada</div>
        <div class="textblock">@if($solutionText !== ''){!! nl2br(e($solutionText)) !!}@else&nbsp;@endif</div>
    </div>

    <div class="box">
        <div class="box-title">Data do Atendimento (Finalizado)</div>
        <table class="field">
            <tr>
                <td class="label">Data:</td>
                <td class="value">{{ $finalDate ?: ' ' }}</td>
            </tr>
        </table>
        <div class="muted" style="margin-top: 6px;">
            Abertura: {{ optional($order->opened_at)->format('d/m/Y H:i') }}
            @if($order->closed_at)
                | Fechamento: {{ optional($order->closed_at)->format('d/m/Y H:i') }}
            @endif
            | Status: {{ $order->status }}
        </div>
    </div>

    <div class="box">
        <div class="box-title">Assinaturas</div>
        <table class="sign-grid">
            <tr>
                <td style="padding-right: 8px;">
                    <div class="sign-box">
                        <div class="sign-title">Técnico Responsável</div>
                        <div class="muted">{{ $technicianName ?: '-' }}</div>
                        <div class="sign-line">Assinatura</div>
                    </div>
                </td>
                <td style="padding-left: 8px;">
                    <div class="sign-box">
                        <div class="sign-title">Cliente</div>
                        @if($order->signature_image)
                            <div class="sign-img">
                                <img src="{{ $order->signature_image }}" alt="Assinatura do Cliente">
                            </div>
                            @if($order->signature_signed_at)
                                <div class="muted" style="margin-top: 6px;">Assinado em {{ $order->signature_signed_at->format('d/m/Y H:i') }}</div>
                            @endif
                        @else
                            <div class="muted">Sem assinatura.</div>
                        @endif
                        <div class="sign-line">Assinatura</div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="box">
        <div class="box-title">Observações</div>
        <div class="textblock small">&nbsp;</div>
    </div>
</body>
</html>
