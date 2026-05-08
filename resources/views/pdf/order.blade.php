<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>OS #{{ $order->number }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111; }
        .row { width: 100%; }
        .title { font-size: 18px; font-weight: bold; margin-bottom: 6px; }
        .muted { color: #666; }
        .box { border: 1px solid #ddd; padding: 10px; margin-bottom: 10px; }
        .section-title { font-weight: bold; margin-bottom: 6px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 6px; vertical-align: top; }
        th { background: #f3f3f3; text-align: left; }
        .right { text-align: right; }
        .sig { border: 1px solid #ddd; padding: 8px; text-align: center; }
        .sig img { max-width: 100%; max-height: 160px; }
    </style>
</head>
<body>
    <div class="title">Ordem de Serviço #{{ $order->number }}</div>
    <div class="muted">
        Abertura: {{ optional($order->opened_at)->format('d/m/Y H:i') }}
        @if($order->closed_at)
            | Fechamento: {{ optional($order->closed_at)->format('d/m/Y H:i') }}
        @endif
        | Status: {{ $order->status }}
    </div>

    @if(!empty($company) && ($company->name || $company->cnpj || $company->logo_image))
        <div class="box">
            <div class="section-title">Empresa prestadora</div>
            <table>
                <tr>
                    <td style="width: 28%; text-align: center;">
                        @if($company->logo_image)
                            <img src="{{ $company->logo_image }}" alt="Logo" style="max-width: 140px; max-height: 80px;">
                        @else
                            <div class="muted">Sem logo</div>
                        @endif
                    </td>
                    <td>
                        <div><b>{{ $company->name ?? '-' }}</b></div>
                        <div>CNPJ: {{ $company->cnpj ?? '-' }}</div>
                        <div class="muted" style="margin-top: 4px;">
                            @if($company->street || $company->number)
                                {{ $company->street ?? '-' }}, {{ $company->number ?? '-' }}
                                @if($company->complement) - {{ $company->complement }} @endif
                                <br>
                                {{ $company->district ?? '-' }} - {{ $company->city ?? '-' }}/{{ $company->state ?? '-' }}
                                <br>
                                CEP: {{ $company->zip ?? '-' }}
                            @else
                                Endereço não informado.
                            @endif
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    @endif

    <div class="box">
        <div class="section-title">Cliente / Solicitante</div>
        <table>
            <tr>
                <th style="width: 28%;">Nome</th>
                <td>{{ $order->client->name }}</td>
            </tr>
            <tr>
                <th>CPF/CNPJ</th>
                <td>{{ $order->client->document }}</td>
            </tr>
            <tr>
                <th>Telefone</th>
                <td>{{ $order->client->phone }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $order->client->email ?? '-' }}</td>
            </tr>
            <tr>
                <th>Endereço</th>
                <td>
                    {{ $order->client->street }}, {{ $order->client->number }}
                    @if($order->client->complement) - {{ $order->client->complement }} @endif
                    <br>
                    {{ $order->client->district }} - {{ $order->client->city }}/{{ $order->client->state }}
                    <br>
                    CEP: {{ $order->client->zip }}
                </td>
            </tr>
        </table>
    </div>

    <div class="box">
        <div class="section-title">Responsável pelo atendimento</div>
        <div>{{ optional($order->responsible)->name ?? '-' }} ({{ optional($order->responsible)->email ?? '-' }})</div>
    </div>

    <div class="box">
        <div class="section-title">Descrição da ordem</div>
        <div>{{ $order->notes ?? '-' }}</div>
    </div>

    @if(!empty($order->solution))
        <div class="box">
            <div class="section-title">Solução</div>
            <div>{{ $order->solution }}</div>
        </div>
    @endif

    <div class="box">
        <div class="section-title">Serviços</div>
        <table>
            <thead>
                <tr>
                    <th>Serviço</th>
                    <th style="width: 70px;" class="right">Qtd</th>
                    @if(empty($hideValues))
                        <th style="width: 110px;" class="right">Valor unit.</th>
                        <th style="width: 110px;" class="right">Subtotal</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($order->services as $service)
                    @php
                        $qty = (int) $service->pivot->quantity;
                        $unit = (float) $service->pivot->unit_value;
                        $sub = $qty * $unit;
                    @endphp
                    <tr>
                        <td>{{ $service->name }}</td>
                        <td class="right">{{ $qty }}</td>
                        @if(empty($hideValues))
                            <td class="right">R$ {{ number_format($unit, 2, ',', '.') }}</td>
                            <td class="right">R$ {{ number_format($sub, 2, ',', '.') }}</td>
                        @endif
                    </tr>
                @endforeach
                @if(empty($hideValues))
                    <tr>
                        <th colspan="3" class="right">Total</th>
                        <th class="right">R$ {{ number_format((float) $order->total_value, 2, ',', '.') }}</th>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <div class="box">
        <div class="section-title">Assinatura do solicitante</div>
        <div class="sig">
            @if($order->signature_image)
                <img src="{{ $order->signature_image }}" alt="Assinatura">
                @if($order->signature_signed_at)
                    <div class="muted" style="margin-top: 6px;">Assinado em {{ $order->signature_signed_at->format('d/m/Y H:i') }}</div>
                @endif
            @else
                <div class="muted">Sem assinatura.</div>
            @endif
        </div>
    </div>
</body>
</html>
