<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>OS #{{ $order->number }}</title>
    <style>
        @page { margin: 15px 24px; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111; }
        table { width: 100%; border-collapse: collapse; }
        .header-shell { margin-bottom: 8px; border: 1px solid #0b2f6a; }
        .header-top { background: #0b3d91; color: #fff; }
        .header-top td { padding: 10px 16px; vertical-align: middle; }
        .logo-wrap { width: 108px; text-align: center; }
        .logo-box { display: inline-block; width: 68px; height: 68px; text-align: center; }
        .logo-box img { max-width: 68px; max-height: 68px; margin-top: 0px; }
        .logo-fallback { color: #fff; font-size: 28px; font-weight: bold; line-height: 88px; letter-spacing: 1px; }
        .header-title { font-size: 22px; font-weight: bold; letter-spacing: .4px; }
        .header-sub { font-size: 12px; opacity: .95; margin-top: 4px; }
        .company-name { font-size: 16px; font-weight: bold; margin-bottom: 3px; }
        .company-line { font-size: 11px; margin-bottom: 2px; opacity: .96; }
        .header-meta { background: #f4f7fb; border-top: 1px solid #d6e1f2; }
        .header-meta td { width: 33.33%; padding: 6px 12px; border-right: 1px solid #d6e1f2; }
        .header-meta td:last-child { border-right: none; }
        .meta-label { display: block; color: #5f6f85; font-size: 10px; text-transform: uppercase; margin-bottom: 3px; }
        .meta-value { font-size: 13px; font-weight: bold; color: #15355f; }
        .box { border: 1px solid #d9d9d9; padding: 6px 10px; margin-bottom: 8px; }
        .box-title { font-weight: bold; margin-bottom: 4px; color: #15355f; }
        .muted { color: #666; }
        .field { width: 100%; }
        .field td { padding: 2px 0; vertical-align: top; }
        .label { width: 130px; color: #333; font-weight: bold; }
        .value { border-bottom: 1px solid #bbb; padding-bottom: 2px; }
        .textblock { min-height: 50px; border: 1px solid #e1e1e1; padding: 6px; }
        .textblock.small { min-height: 40px; }
        .sign-box { border: 1px solid #e1e1e1; padding: 6px; min-height: 50px; }
        .sign-title { font-weight: bold; margin-bottom: 8px; color: #15355f; }
        .sign-line { border-top: 1px solid #111; margin-top: 40px; padding-top: 4px; color: #333; }
        .sign-img { text-align: center; }
        .sign-img img { max-width: 50%; max-height: 50px; }
        .sign-meta { margin-top: 10px; }
        .sign-meta td { padding: 3px 0; vertical-align: top; }
        .page-break { page-break-before: always; }
        .confirmation-page { min-height: 100%; }
    </style>
</head>
<body>
    @php
        $safeNumber = str_pad((string) $order->number, 6, '0', STR_PAD_LEFT);
        $clientName = trim((string) ($order->client_name ?: ($order->client?->name ?: '')));
        $clientDocument = trim((string) ($order->client_document ?: ($order->client?->document ?: '')));
        $clientPhone = $order->client?->phone ?: '';
        $clientEmail = $order->client?->email ?: '';
        $problemText = trim((string) ($order->notes ?? ''));
        $solutionText = trim((string) ($order->solution ?? ''));
        $finalDate = $order->closed_at ? optional($order->closed_at)->format('d/m/Y') : '';
        $companyName = trim((string) ($company?->name ?? ''));
        $companyLogo = $company?->logo_image ?: null;
        $gdAvailable = extension_loaded('gd') || function_exists('imagecreatetruecolor');
        $companyCnpj = preg_replace('/\D+/', '', (string) ($company?->cnpj ?? ''));
        if (strlen($companyCnpj) === 14) {
            $companyCnpj = preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $companyCnpj);
        } else {
            $companyCnpj = trim((string) ($company?->cnpj ?? ''));
        }
        $companyPhone = trim((string) ($company?->phone ?? ''));
        $companyEmail = trim((string) ($company?->email ?? ''));
        $addressParts = array_filter([
            trim((string) ($company?->street ?? '')),
            trim((string) ($company?->number ?? '')),
            trim((string) ($company?->complement ?? '')),
            trim((string) ($company?->district ?? '')),
            trim((string) ($company?->city ?? '')),
            trim((string) ($company?->state ?? '')),
            trim((string) ($company?->zip ?? '')),
        ], fn ($value) => $value !== '');
        $companyAddress = implode(' - ', $addressParts);
    @endphp

    <div class="header-shell">
        <table class="header-top">
            <tr>
                <td class="logo-wrap">
                    <div class="logo-box">
                        @if($companyLogo && $gdAvailable)
                            <img src="{{ $companyLogo }}" alt="Logo da empresa">
                        @else
                            <div class="logo-fallback">OS</div>
                        @endif
                    </div>
                </td>
                <td>
                    <div class="company-name">{{ $companyName !== '' ? $companyName : 'Sua Empresa' }}</div>
                    @if($companyCnpj !== '')
                        <div class="company-line">CNPJ: {{ $companyCnpj }}</div>
                    @endif
                    @if($companyAddress !== '')
                        <div class="company-line">{{ $companyAddress }}</div>
                    @endif
                    @if($companyPhone !== '' || $companyEmail !== '')
                        <div class="company-line">
                            {{ $companyPhone !== '' ? $companyPhone : '' }}
                            @if($companyPhone !== '' && $companyEmail !== '')
                                |
                            @endif
                            {{ $companyEmail !== '' ? $companyEmail : '' }}
                        </div>
                    @endif
                </td>
                <td style="width: 210px; text-align: right;">
                    <div class="header-title">ORDEM DE SERVIÇO</div>
                    <div class="header-sub">Documento de atendimento e conclusão</div>
                </td>
            </tr>
        </table>

        <table class="header-meta">
            <tr>
                <td>
                    <span class="meta-label">Número da OS</span>
                    <span class="meta-value">{{ $safeNumber }}</span>
                </td>
                <td>
                    <span class="meta-label">Status</span>
                    <span class="meta-value">{{ ucfirst(str_replace('_', ' ', $order->status)) }}</span>
                </td>
                <td>
                    <span class="meta-label">Data de fechamento</span>
                    <span class="meta-value">{{ $finalDate !== '' ? $finalDate : '-' }}</span>
                </td>
            </tr>
        </table>
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
                <td class="label">Documento:</td>
                <td class="value">{{ $clientDocument ?: ' ' }}</td>
            </tr>
            <tr>
                <td class="label">Email:</td>
                <td class="value">{{ $clientEmail ?: ' ' }}</td>
            </tr>
        </table>
    </div>

    <div class="box">
        <div class="box-title">Data do Atendimento (Finalizado)</div>
        <table class="field">
            <tr>
                <td class="label">Data:</td>
                <td class="value">{{ $finalDate ?: ' ' }}</td>
            </tr>
            <tr>
                <td class="label">Técnico responsável:</td>
                <td class="value">{{ $order->responsible?->name ?: ' ' }}</td>
            </tr>
        </table>
        <div class="muted" style="margin-top: 2px;">
            Abertura: {{ optional($order->opened_at)->format('d/m/Y H:i') }}
            @if($order->closed_at)
                | Fechamento: {{ optional($order->closed_at)->format('d/m/Y H:i') }}
            @endif
            | Status: {{ $order->status }}
        </div>
    </div>

       <div class="box">
            <div class="box-title">Descrição do Problema</div>
            <div class="textblock small">@if($problemText !== ''){!! nl2br(e($problemText)) !!}@else&nbsp;@endif</div>
        </div>

        <div class="box">
            <div class="box-title">Solução Realizada</div>
            <div class="textblock small">@if($solutionText !== ''){!! nl2br(e($solutionText)) !!}@else&nbsp;@endif</div>
        </div>

        <div class="box">
            <div class="box-title">Confirmação do Cliente</div>
            <div class="sign-box">
                @if($order->signature_image && $gdAvailable)
                    <div class="sign-img">
                        <img src="{{ $order->signature_image }}" alt="Assinatura do Cliente">
                    </div>
                    @if($order->signature_signed_at)
                        <div class="muted" style="margin-top: 6px;">Assinado em {{ $order->signature_signed_at->format('d/m/Y H:i') }}</div>
                    @endif
                @elseif($order->signature_image && ! $gdAvailable)
                    <div class="muted">Assinatura indisponível: extensão GD não instalada.</div>
                @else
                    <div class="muted">Sem assinatura.</div>
                @endif
                <table class="field sign-meta">
                    <tr>
                        <td class="label">Nome:</td>
                        <td class="value">{{ $clientName ?: ' ' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Documento:</td>
                        <td class="value">{{ $clientDocument ?: ' ' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        

       
    
</body>
</html>
