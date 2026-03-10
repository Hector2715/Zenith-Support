@extends('layouts.pdf')

@section('content')
<div class="ticket-container">
    <div class="text-center" style="border-bottom: 1px dashed #ccc; padding-bottom: 10px; margin-bottom: 10px;">
        <div class="text-navy font-black" style="font-size: 16px;">ZENITH <span class="text-teal">SUPPORT</span></div>
        <div style="font-size: 9px;" class="uppercase">{{ auth()->user()->nombre_taller }}</div>
        <div style="font-size: 8px;">{{ $equipo->created_at->format('d/m/Y H:i') }}</div>
    </div>

    <span class="label-mini uppercase">Orden #</span>
    <div class="value-mini">{{ str_pad($equipo->id, 6, '0', STR_PAD_LEFT) }}</div>

    <span class="label-mini uppercase">Cliente</span>
    <div class="value-mini">{{ $equipo->name_client ?? 'General' }}</div>
    
    <span class="label-mini uppercase">Equipo / Modelo</span>
    <div class="value-mini">{{ $equipo->modelo }}</div>

    <span class="label-mini uppercase">Falla Reportada</span>
    <div class="value-mini" style="background: #f1f5f9; padding: 5px; border-radius: 3px;">{{ $equipo->falla }}</div>

    {{-- Términos Legales --}}
    <div style="margin-top: 15px; font-size: 7px; color: #666; line-height: 1.2;">
        <strong>CONDICIONES:</strong> 1. Garantía de 30 días. 2. Equipos abandonados por 90 días serán dispuestos para cubrir costos. 3. No nos responsabilizamos por datos no respaldados.
    </div>

    <div class="signature-box uppercase text-center" style="margin-top: 30px;">
        Firma Cliente
    </div>

    <div class="footer-pdf">
        Generado por Zenith Support v2.0
    </div>
</div>
@endsection